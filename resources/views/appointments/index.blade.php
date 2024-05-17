
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="myappointment"></x-navbars.sidebar>
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
    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal"> Create Appointment </button>
        <h2>Appointments List</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Client Name</th>
                    <th>Appointment Time</th>
                    <th>Service Type</th>
                    <th>Price</th>
                    <th>Status </th>
                    <th>Action </th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($appointment->schedule)->format('F d Y h:ia')}}</td>
                        <td>{{ $appointment->servicename }}</td>
                        <td>PHP {{ number_format($appointment->serviceprice,2) }}</td> 
                        <!-- <td>{{ $appointment->status}}</td> -->
                        <td>{{ $appointment->status == 1 ? 'Approved' : ($appointment->status == 2 ? 'Rejected' : ($appointment->status == 3 ? 'Walk-in' : ($appointment->status == 4 ? 'Paid' : 'Pending') ))}}</td>
                         <td>
                            <?php
                                if($appointment->status > 0 || $appointment->status < 0){
                                    echo 'No available action';
                                }else{
                            ?>
                            <span style="padding-bottom: 10px;">
                                <button type="button" class="btn btn-success edit-btn"  data-bs-toggle="modal" data-bs-target="#editApp" appointmentId="{{ $appointment->appointmentID }}" id="editAppointment">Edit</button>
                            </span>
                                <button type="button" class="btn btn-danger reject-btn" appointmentId="{{ $appointment->appointmentID }}"  id="deleteAppointment">Delete</button>
                            @php
                                    }
                            @endphp
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
                        <input type="number" class="form-control d-none" id="status" name="status" value="0">
                        <div class="mb-3">
                            <label for="service" class="col-form-label">Service Type:</label>
                            <select class="form-select px-3 py-1" id="service" name="service">
                                @foreach ($services as $service )
                                    <option value="{{ $service->id }}" price="{{ $service->serviceprice }}" {{ $service->servicestatus == 1 ? 'disabled' : '' }}>{{ $service->servicename }} {{ $service->servicestatus == 1 ? '(Not available)' : '' }}</option>
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
                    <button type="button" class="btn btn-primary" id="reqApp">Request</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editApp" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">New Appointment</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateAppointment">
                        @csrf
                        <input type="text" class="d-none" name="editAppID" id="editAppID">
                        <div class="mb-3">
                            <label for="editservice" class="col-form-label">Service Type:</label>
                            <select class="form-select px-3 py-1" id="editservice" name="editservice">
                                @foreach ($services as $service )
                                    <option value="{{ $service->id }}" price="{{ $service->serviceprice }}" {{ $service->servicestatus == 1 ? 'disabled' : '' }}>{{ $service->servicename }} {{ $service->servicestatus == 1 ? '(Not available)' : '' }}</option>
                                @endforeach
                                <!-- Add more options as needed -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="col-form-label">Price (PHP):</label>
                            <input type="text" class="form-control-plaintext px-3 border-0" id="editprice" name="editprice" class="px-3" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="schedule" class="col-form-label">Date:</label>
                            <input type="datetime-local" class="form-control px-3" id="editschedule" name="editschedule"  min="{{ \Carbon\Carbon::now() }}">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateApp">Update</button>
                </div>
            </div>
        </div>
    </div>



<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(()=>{

        var selectedOption = $('#service').find('option:selected');

        var price = selectedOption.attr('price');

        $('#price').val(price);

    })


    $('#reqApp').on('click', function(e) {
        $.ajax({
            method: 'post',
            url: 'appointments/create',
            data: $('#createAppointment').serialize(),
            dataType: 'json',
            success: function(response) {
                Swal.fire({
                    title: 'Added!',
                    text: 'The appointment has been successfully added!.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonClass: 'btn btn-success',
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });
            },
            error: function(xhr, status, error) {
                // $("#error").html(xhr.responseJSON.message);
            }
        });
    });

    $('#service').on('change', function() {

        var selectedOption = $(this).find('option:selected');

        var price = selectedOption.attr('price');

        $('#price').val(price);
    });

    $('#editservice').on('change', function() {

        var selectedOption = $(this).find('option:selected');

        var price = selectedOption.attr('price');

        $('#editprice').val(price);
    });

    $(document).on('click','#editAppointment', function(e) {
        var appId = $(this).attr('appointmentId');
        $('#editservice').val('')
        $('#editprice').val('')
        $('#editschedule').val('')
        $.ajax({
            method: 'get',
            url: 'appointments/get/'+appId,
            dataType: 'json',
            success: function(response) {
                var appointment = response[0];
                var serviceId = appointment.id;

                var option = $('#editservice').find('option').filter(function() {
                    return $(this).val() == serviceId;
                });

                if (option.length > 0) {
                    option.prop('selected', true);
                } else {
                    console.log('Service not found:', serviceId);
                }
                $('#editAppID').val(appId)
                $('#editprice').val(appointment.serviceprice)
                $('#editschedule').val(appointment.schedule)
            }
        });
    });

    $('#updateApp').on('click', function() {
        $.ajax({
            method: 'post',
            url: 'appointments/update',
            data: $('#updateAppointment').serialize(),
            dataType: 'json',
            success: function(response) {
                Swal.fire({
                    title: 'Updated!',
                    text: 'The appointment has been successfully updated!.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonClass: 'btn btn-success',
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });
            }
        });
    });

    $(document).on('click', '#deleteAppointment', function() {
        var appId = $(this).attr('appointmentId');

        
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you really want to delete this appointment?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it',
            customClass: {
                confirmButton: 'custom-confirm-btn btn btn-danger',
                cancelButton: 'custom-cancel-btn btn btn-secondary'
            },
            // buttonsStyling: false
        }).then((result)=>{
            if (result.isConfirmed){
                $.ajax({
                    method: 'post',
                    url: 'appointments/delete/' + appId,
                    data:{
                        '_token': '{{ csrf_token() }}',
                    },
                    dataType: 'json',
                    success: function(response) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'The appointment has been successfully deleted!.',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            confirmButtonClass: 'btn btn-success',
                            buttonsStyling: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    }
                });
            }
        })
        
    });

</script>


</x-layout>

