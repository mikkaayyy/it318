
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="appointments.index"></x-navbars.sidebar>
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
           <div class="container mt-5 d-flex justify-content-center">
           <meta name="csrf-token" content="{{ csrf_token() }}">
           <head>
    <!-- Other head elements -->
              <meta name="csrf-token" content="{{ csrf_token() }}">
          </head>

    <main>
        <h2>Appointments List</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Client Name</th>
                    <th>Appointment Time</th>
                    <th>Service Type</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Status Update</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                    <tr>
                    
                        <td>{{ $appointment->name }}</td>
                        <td>{{ $appointment->schedule }}</td>
                        <td>{{ $appointment->description }}</td>
                        <td>{{ $appointment->status}}</td>
                        <td>{{ $appointment->status_update }}</td>
                         <td>
                         <span style="padding-bottom: 10px;">
                         <button class="btn btn-success approve-btn" data-appointment-id="{{ $appointment->id }}">Approve</button>
                       </span>
                       <a class="btn btn-danger reject-btn" data-appointment-id="{{ $appointment->id }}" href="#">Reject</a>
                      </td>


                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- Add these to the <head> of your HTML -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    $('#reqApp').on('click', function(e) {
        $.ajax({
            method: 'post',
            url: 'appointments/create',
            data: $('#createAppointment').serialize(),
            dataType: 'json',
            success: function(response) {
                console.log(response); 
                // if (response.status_code == 0) {
                //     window.location.href = "{{route('dashboard')}}";
                // } else {
                //     $('#error').html('<div>' + response.msg + '</div>');
                // }
            },
            error: function(xhr, status, error) {
                console.log(error); 
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
});
</script>


</x-layout>

