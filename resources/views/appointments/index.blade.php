
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
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createAppointmentModal"> Create Appointment </button>
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
            <tbody>
                
            </tbody>
        </table>
    </main>
</div>

</x-layout>

