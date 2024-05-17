<?php 
    use Illuminate\Support\Facades\Crypt;
?>
<!-- user-management.blade.php -->
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="user-management"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="User Management"></x-navbars.navs.auth> 
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4"> 
                        <!-- Your card content here -->
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            {{-- <th>ID</th> --}}
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                            <!-- Add more columns as needed -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                
                                        @foreach($users as $user)
                                        <tr>
                                        
                                            {{-- <td>{{ Crypt::encryptString($user->id) }}</td> --}}
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->role }}</td>
                                            <td>
                                                <button type="button" class="btn btn-success edit-btn"  data-bs-toggle="modal" data-bs-target="#editUser" userId="{{Crypt::encryptString($user->id)}}" id="Clickedit">Edit</button>
                                                <button class="btn btn-danger delete-btn" userId="{{ Crypt::encryptString($user->id) }}" href="#">Delete</button>
                                            </td>
                                            <!-- Add more columns as needed -->
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>

<div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">User Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateUser">
                    @csrf
                    <input type="text" class="d-none" name="encryptedUserId" id="encryptedUserId">
                    <div class="mb-3">
                        <label for="editname" class="col-form-label">Name:</label>
                        <input type="text" class="form-control px-3" id="editname" name="editname" class="px-3">
                    </div>
                    <div class="mb-3">
                        <label for="editemail" class="col-form-label">Email Address:</label>
                        <input type="text" class="form-control px-3" id="editemail" name="editemail" class="px-3">
                    </div>
                    <div class="mb-3">
                        <label for="editpass" class="col-form-label">Password:</label>
                        <input type="password" class="form-control px-3" id="editpass" name="editpass" placeholder="new password">
                    </div>
                    <div class="mb-3">
                        <label for="editType" class="col-form-label">Role:</label>
                        <select class="form-select px-3" name="editType" id="editType">
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateUserBtn">Update</button>
            </div>
        </div>
    </div>
</div>


<script>

    $(document).on('click', '#updateUserBtn', function() {
        
        $.ajax({
            method: 'POST',
            url: 'user/update',
            dataType: 'json',
            data: $('#updateUser').serialize(),
            success: function(response) {
                if (response.status_code == 0) {
                    // Show success message with SweetAlert
                    Swal.fire({
                        title: 'Success!',
                        text: 'The user has been successfully updated.',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        confirmButtonClass: 'btn btn-success',
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonClass: 'btn btn-danger',
                        buttonsStyling: false
                    });
                }
            },
            error: function(xhr, status, error) {
                // Handle AJAX error with SweetAlert
                var errorMessage = 'There was an issue approving the appointment.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                Swal.fire({
                    title: 'Error!',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonClass: 'btn btn-danger',
                    buttonsStyling: false
                });
                console.error('Error status:', status);
                console.error('Error details:', error);
                console.error('Response text:', xhr.responseText);
            }
        });

    });

    $(document).on('click', '.delete-btn', function() {
        var userId = $(this).attr('userId');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you really want to delete this User?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it',
            customClass: {
                confirmButton: 'custom-confirm-btn btn btn-danger',
                cancelButton: 'custom-cancel-btn btn btn-secondary'
            },
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: 'POST',
                    url: 'user/delete/' + userId,
                    dataType: 'json',
                    data: {'_token': '{{ CSRF_TOKEN() }}'},
                    success: function(response) {
                        // Show success message with SweetAlert
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'The user has been successfully deleted!',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            confirmButtonClass: 'btn btn-success',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Reload the page or update UI as needed
                                window.location.reload();
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });

    $(document).on('click','#Clickedit', function(e) {
        var userId = $(this).attr('userId');
        $('#editname').val('')
        $('#editemail').val('')
        $('#editpass').val('')
        $('#editType').val('')
        $('#encryptedUserId').val('')
        $.ajax({
            method: 'get',
            url: 'user/get/'+userId,
            dataType: 'json',
            success: function(response) {
                $('#encryptedUserId').val(userId)
                $('#editname').val(response.name)
                $('#editemail').val(response.email)
                $('#editpass').val(response.password)
                $('#editType').val(response.role)
            }
        });
    });
</script>