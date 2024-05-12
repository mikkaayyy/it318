
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="appointments.index"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg d-flex justify-content-center align-items-center">
        <div class="container py-4">
         </div>
        <div class="container-fluid py-2">
            <div class="row">
                <div class="col-lg-10 col-md-5">
                    <div class="card mt-2">
                        <div class="card-header p-10">
           <div class="container mt-5 d-flex justify-content-center">
    <main>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"> Create Appointment </button>
        <h2>Appointments List</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Client Name</th>
                    <th>Appointment Time</th>
                    <th>Service Type</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                    <tr>
                    
                        <td>{{ $appointment->name }}</td>
                        <td>{{ $appointment->schedule }}</td>
                        <td>{{ $appointment->description }}</td>
                        <td>{{ $appointment->status = ($appointment->status == 0) ? 'Pending' : 'Approved' }}</td>
                        <!-- Add more columns as needed -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">New message</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createAppointment">
                    @csrf
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Service Type:</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Date:</label>
                        <input type="datetime-local" class="form-control" id="schedule" name="schedule">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="reqApp">Request</button>
            </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $('#reqApp').on('click', function(e) {
        $.ajax({
            method: 'post',
            url: 'appointments/create',
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
</x-layout>

