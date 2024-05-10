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
                            <div class="modal fade" id="createAppointmentModal" tabindex="-1" aria-labelledby="createAppointmentModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createAppointmentModal">Create Appointment</button>
                                            <h5 class="modal-title" id="createAppointmentModalLabel">Create Appointment</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
    <form id="appointmentForm" action="{{ route('appointments.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="client_name">Client Name</label>
            <input type="text" class="form-control" id="client_name" name="client_name">
        </div>
        <div class="form-group">
            <label for="appointment_time">Appointment Time</label>
            <input type="datetime-local" class="form-control" id="appointment_time" name="appointment_time">
        </div>
        <div class="form-group">
            <label for="service_type">Service Type</label>
            <input type="text" class="form-control" id="service_type" name="service_type">
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" id="price" name="price">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

                            <div class="container mt-5 d-flex justify-content-center">
                                <main>
                                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createAppointmentModal"> Create Appointment </button> -->
                                    <h2>Appointments List</h2>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Client Name</th>
                                                <th>Appointment Time</th>
                                                <th>Service Type</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody id="appointmentsTable">
                                            <!-- Appointments will be appended here -->
                                        </tbody>
                                    </table>
                                </main>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#appointmentForm').submit(function(e){
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#appointmentForm')[0].reset();
                        $('#createAppointmentModal').modal('hide');
                        alert('Appointment created successfully!');
                        fetchAppointments();
                    },
                    error: function(xhr) {
                        alert('Error occurred while creating appointment!');
                    }
                });
            });

            function fetchAppointments() {
                $.ajax({
                    url: "{{ route('appointments.index') }}",
                    type: "GET",
                    success: function(response) {
                        $('#appointmentsTable tbody').empty();
                        response.forEach(function(appointment) {
                            $('#appointmentsTable tbody').append(`
                                <tr>
                                    <td>${appointment.id}</td>
                                    <td>${appointment.client_name}</td>
                                    <td>${appointment.appointment_time}</td>
                                    <td>${appointment.service_type}</td>
                                    <td>${appointment.price}</td>
                                    <td>${appointment.created_at}</td>
                                    <td>${appointment.updated_at}</td>
                                </tr>
                            `);
                        });
                    },
                    error: function(xhr) {
                        
                        alert('Error occurred while fetching appointments!');
                    }
                });
            }

           
            fetchAppointments();
        });
    </script>
    @endpush
</x-layout>
