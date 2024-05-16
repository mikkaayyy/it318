<x-layout bodyClass="">
    <div>
        <div class="container position-sticky z-index-sticky top-0">
            <div class="row">
                <div class="col-15">
                    <!-- Navbar -->
                    <x-navbars.navs.guest signin='static-sign-in' signup='static-sign-up'></x-navbars.navs.guest>
                    <!-- End Navbar -->
                </div>
            </div>
        </div>
        <main class="main-content  mt-0">
            <section>
                <div class="page-header min-vh-150">
                    <div class="container">
                        <div class="row">
                            <div
                                class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
                                <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center"
                                    style="background-image: url('{{ asset('assets') }}/'); background-size: cover;">
                                </div>
                            </div>
                            <div
                                class="col-xl-5 col-lg-2 col-md-10 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-50">
                                <div class="card card-plain">
                                <div class="container">
                                    <div class="card-header">
                                        <h4 class="font-weight-bolder">Sign Up</h4>
                                        <p class="mb-0"></p>
                                    </div>
                                    <div class="card-body">
                                        <form id="signupForm">
                                        @csrf
                                            <div class="input-group input-group-outline mb-3 ">
                                                {{-- <label class="form-label">User Role</label> --}}
                                                <select class="form-select px-3" name="role" required>
                                                    {{-- <option value="">--Select--</option> --}}
                                                    <option value="admin">Admin</option>
                                                    <option value="user" selected>Client</option>
                                                </select>
                                            </div>
                                            <div class="input-group input-group-outline mb-3">
                                                <label class="form-label">FirstName</label>
                                                <input type="text" class="form-control" name="name" required>
                                            </div>
                                            <div class="input-group input-group-outline mb-3">
                                                <label class="form-label">Lastname</label>
                                                <input type="text" class="form-control" name="name" required>
                                            </div>
                                            <div class="input-group input-group-outline mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" required>
                                            </div>
                                            <div class="input-group input-group-outline mb-3">
                                                <label class="form-label">Password</label>
                                                <input type="password" class="form-control" name="password" required>
                                                @error('password')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="input-group input-group-outline mb-3">
                                                <label class="form-label">Phone Number</label>
                                                <input type="text" class="form-control" name="phone" required>
                                            </div>
                                            {{-- <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Appointment</label>
                                             <input type="text" class="form-control" id="datetimepicker" name="dob" required>
                                              </div> --}}

                                              <div class="input-group input-group-outline mb-3">
                                                    <label class="form-label">OTP</label>
                                                    <input type="text" class="form-control" name="otp" id="otp" required>
                                                </div>
                                                <div class="text-center mb-3">
                                                    <button type="button" id="send-otp" class="btn btn-secondary" onclick="sendOTP()">Send OTP</button>
                                                </div>

                                            <!-- <div class="form-check form-check-info text-start ps-0">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="flexCheckDefault" checked>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    I agree the <a href="javascript:;"
                                                        class="text-dark font-weight-bolder">Terms and Conditions</a>
                                                </label>
                                            </div> -->
                                            <div id="error" style="color: red;"></div>
                                            <div class="text-center">
                                                <button type="button" id="sing-upbtn"
                                                    class="btn btn-lg bg-gradient-success btn-lg w-100 mt-4 mb-0">Sign
                                                    Up</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                        <p class="mb-2 text-sm mx-auto">
                                            Already have an account?
                                            <a href="{{ route('static-sign-in') }}"
                                                class="text-primary text-gradient font-weight-bold">Sign in</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</x-layout>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.en.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        $('#datetimepicker').datepicker({
            format: 'mm/dd/yyyy',
            autoclose: true,
            todayHighlight: true
        });
    });
    
    $('#sing-upbtn').on('click', function(e) {
        $.ajax({
            method: 'post',
            url: 'store-sign-up',
            data: $('#signupForm').serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status_code == 0) {
                    window.location.href = "{{route('dashboard')}}";
                } else {
                    $('#error').html('<div>' + response.msg + '</div>');
                } 
            },
            error: function(xhr, status, error) {
                console.log(error); 
                $("#error").html(xhr.responseJSON.message);
            }
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script >
// $(document).ready(function(){
//     sendOTP();
// });

function sendOTP(){

        $.ajax({
            url: 'send-otp',
            method: 'post',
            data: { 
                'email': $('#email').val(),
                '_token': '{{ csrf_token() }}'
            },
            dataType: 'json',
            cache: false,

            beforeSend:function(){
                $("#btn-Otp").html("Sending...");
                $("#btn-Otp").prop("disabled", true);
            },

            success:function(data){
                $("#btn-Otp").html("SEND OTP");
                $("#btn-Otp").prop("disabled", false);
                console.log(data.otp);
                if (data.message == 'success') {
                    Swal.fire({
                        title: "Information",
                        text: "OTP was sent to entered email",
                        icon: "success"
                      });
                } else {
                    Swal.fire({
                        title: "Information",
                        text: "Failed to send OTP",
                        icon: "info"
                      });
                }
            },
            error:function(xhr, status, error){
                console.log(xhr.responseText);
            }
        });

}
</script>