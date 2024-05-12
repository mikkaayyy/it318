
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
                        <td>{{ $appointment->status = ($appointment->status == 0) ? 'pending' : 'Approved'; }}</td>
                        <!-- Add more columns as needed -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
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
</x-layout>

