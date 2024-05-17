
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="allappointment"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg d-flex justify-content-center align-items-center">
        <div class="container py-4">
         </div>
        <div class="container-fluid py-2">
        <div class="container-fluid px-2 px-md-4">
            <div class="row">
                <div class="col-lg-10 col-md-5">
                    <div class="card mt-2">
                        <div class="card-header p-10">

                        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
                      <style>
                         .top-center {
                        position: absolute;
                        top: 10px;
                        left: 50%;
                        transform: translateX(-50%);
                        width: 80%
                        }
                      </style>
                      <style>
        .swal2-actions .swal2-confirm {
            margin-right: 10px; /* Adjust the space between buttons */
        }
    </style>
           <div class="container mt-5 d-flex justify-content-center">
           <meta name="csrf-token" content="{{ csrf_token() }}">
           <head>
    <!-- Other head elements -->
              <meta name="csrf-token" content="{{ csrf_token() }}">
          </head>

    <main>
        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal"> Create Appointment </button>
        <h2>Appointments List</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Client Name</th>
                    <th>Appointment Time</th>
                    <th>Service Type</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->name }} {{ $appointment->status == 3 ? '(Admin)' : '' }}</td>
                        <td>{{ \Carbon\Carbon::parse($appointment->schedule)->format('F d Y h:ia')}}</td>
                        <td>{{ $appointment->servicename }}</td>
                        <td>PHP {{ number_format($appointment->serviceprice,2) }}</td> 
                        <!-- <td>{{ $appointment->status}}</td> -->
                        <td>{{ $appointment->status == 1 ? 'Approved' : ($appointment->status == 2 ? 'Rejected' : ($appointment->status == 3 ? 'Walk-in' :($appointment->status == 4 ? 'Paid' : 'Pending') ))}}</td>
                        <td align="center">
                            <?php
                                if($appointment->status > 1 || $appointment->status < 0){
                                    echo 'No action available';
                                }elseif($appointment->status == 1){
                            ?>
                                <a class="btn btn-danger paid-btn" data-appointment-id="{{ $appointment->appointmentID }}" href="#">Paid</a>
                            <?php
                                }else{
                            ?>
                                <span style="padding-bottom: 10px;">
                                    <button class="btn btn-success approve-btn" data-appointment-id="{{ $appointment->appointmentID }}">Approve</button>
                                </span>
                                    <a class="btn btn-danger reject-btn" data-appointment-id="{{ $appointment->appointmentID }}" href="#">Reject</a>
                            <?php } ?>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">New Appointment</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createAppointment">
                        @csrf
                        <input type="number" class="form-control d-none" id="status" name="status" value="3">
                        <div class="mb-3">
                            <label for="service" class="col-form-label">Service Type:</label>
                            <select class="form-select px-3 py-1" id="service" name="service">
                                @foreach ($services as $service )
                                    <option value="{{ $service->id }}" price="{{ $service->serviceprice }}">{{ $service->servicename }}</option>
                                @endforeach
                                <!-- Add more options as needed -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="col-form-label">Price (PHP):</label>
                            <input type="text" class="form-control-plaintext px-3 border-0" id="price" name="price" class="px-3" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="schedule" class="col-form-label">Date:</label>
                            <input type="datetime-local" class="form-control px-3" id="schedule" name="schedule" min="{{ \Carbon\Carbon::now() }}">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="reqApp">Add</button>
                </div>
            </div>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- Add these to the <head> of your HTML -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    $(document).ready(()=>{

        var selectedOption = $('#service').find('option:selected');

        var price = selectedOption.attr('price');

        $('#price').val(price);

    })
    $('#service').on('change', function() {

        var selectedOption = $(this).find('option:selected');

        var price = selectedOption.attr('price');

        $('#price').val(price);
    });

    $('#reqApp').on('click', function(e) {
        $.ajax({
            method: 'post',
            url: 'create',
            data: $('#createAppointment').serialize(),
            dataType: 'json',
            success: function(response) {
                window.location.reload();
                // if (response.status_code == 0) {
                // } else {
                //     $('#error').html('<div>' + response.msg + '</div>');
                // }
            },
            error: function(xhr, status, error) {
                // $("#error").html(xhr.responseJSON.message);
            }
        });
    });
</script>

<script>
    // Set up the CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click', '.approve-btn', function() {
        var appointmentId = $(this).data('appointment-id');
        $.ajax({
            method: 'POST',
            url: '/approve_appointment/' + appointmentId,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Show success message with SweetAlert
                    Swal.fire({
                        title: 'Approved!',
                        text: 'The appointment has been successfully approved.',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        confirmButtonClass: 'btn btn-success',
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Reload the page or update UI as needed
                            window.location.reload();
                        }
                    });
                } else {
                    // Show error message from response
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

</script>




<script>
$(document).on('click', '.reject-btn', function() {
    var appointmentId = $(this).data('appointment-id');
    
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you really want to reject this appointment?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, reject it!',
        cancelButtonText: 'No, keep it',
        customClass: {
            confirmButton: 'custom-confirm-btn btn btn-danger',
            cancelButton: 'custom-cancel-btn btn btn-secondary'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                method: 'POST',
                url: '/reject_appointment/' + appointmentId,
                dataType: 'json',
                success: function(response) {
                    // Show success message with SweetAlert
                    Swal.fire({
                        title: 'Rejected!',
                        text: 'The appointment has been successfully rejected.',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        confirmButtonClass: 'btn btn-success',
                        buttonsStyling: false
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


$(document).on('click', '.paid-btn', function() {
    var appointmentId = $(this).data('appointment-id');
    
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you really want to mark this appointment PAID?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, PAID it!',
        cancelButtonText: 'No',
        customClass: {
            confirmButton: 'custom-confirm-btn btn btn-danger',
            cancelButton: 'custom-cancel-btn btn btn-secondary'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                method: 'POST',
                url: '/paid_appointment/' + appointmentId,
                dataType: 'json',
                success: function(response) {
                    // Show success message with SweetAlert
                    Swal.fire({
                        title: 'PAID!',
                        text: 'The appointment has been successfully PAID.',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        confirmButtonClass: 'btn btn-success',
                        buttonsStyling: false
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
</script>


</x-layout>

