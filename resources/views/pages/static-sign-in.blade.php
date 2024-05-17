<x-layout bodyClass="bg-gray-100">
    <!-- <div class="container position-sticky z-index-sticky ">
        <div class="row">
            <div class="col-12"> -->
                <!-- Navbar -->
                <!-- <x-navbars.navs.guest signin='static-sign-in' signup='static-sign-up'></x-navbars.navs.guest> 
                <!-- End Navbar -->
            </div>
        </div>
    </div>
    <main class="main-content  mt-0">
    <div class="page-header align-items-center min-vh-100 pt-5 pb-25 m-0 border-radius-lg" style="background-image: url('../assets/img/Salon-min.png');">
        <!-- <div class="page-header align-items-start min-vh-100"
        style="background-image: url('https://salonpovera.com/hair-salon-blog/hair-salon-services-what-are-the-options//hair-salon-background.jpg'); background-size: cover;">
            <span class="mask bg-gradient-dark opacity-5"></span> -->
            <div class="container my-auto"> 
                <div class="row">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                    <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Hair Salon Appointment System</h4>
                                    <div class="row mt-3">
                                        <div class="col-2 text-center ms-auto">
                                        </div>
                                        <div class="col-2 text-center px-1">
                                        </div>
                                        <div class="col-2 text-center me-auto">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                          
                                <div id="g_id_onload"
                                data-client_id="{{env('GOOGLE_CLIENT_ID')}}"
                                data-callback="onSignIn">
                            </div>
                            <div class="g_id_signin form-control" data-type="standard"></div>
                                <form  id = "loginForm">
                                    @csrf
                                    <div class="input-group input-group-outline my-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" required>
                                    </div>
                                    <div class="input-group input-group-outline mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" required>
                                    </div>
                                    <div class="form-check form-switch d-flex align-items-center mb-3">
                                        <input class="form-check-input" type="checkbox" id="rememberMe">
                                        <label class="form-check-label mb-0 ms-2" for="rememberMe">Remember
                                            me</label>
                                    </div>
                                    <div class="text-center">
                                        <button type="button" id = "signinbutton" class="btn bg-success text-white w-100 my-2 mb-2">Login</button>
                                    </div>
                                    <div id="error" style="color: red;"></div>
                                    <p class="mt-4 text-sm text-center">
                                                                Don't have an account?
                                 <a href="{{ route('sign-up') }}" class="text-primary text-gradient font-weight-bold">Sign Up</a>
                                     </p>

                                    <!-- <p id="error_message"></p> -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.guest></x-footers.guest>
        </div>
    </main>

</x-layout>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
crossorigin="anonymous"></script>
<!-- <script src="https://accounts.google.com/gsi/client" async defer></script> -->

<script>
   
  
    $('#signinbutton').on('click', function() {
        //  e.preventDefault();
        // alert("Clicked");
        $.ajax({
            method: 'post',
            url: 'verify-sign-in',
            data: $('#loginForm').serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status_code == 0) {
                    if( response.role == 'user' ){
                        window.location.href = "{{route('dashboard')}}";
                    }else{

                        window.location.href = "{{route('admindashboard')}}";
                    }
                } else {
                    $('#error').html('<div>' + response.msg + '</div>');
                }
            },
            error: function(xhr, status, error) {
                console.log(error); 
                // alert(xhr.responseJSON.message);
                $("#error").html(xhr.responseJSON.message);
                // if (xhr.responseJSON && xhr.responseJSON.message === 'Too many failed login attempts.') {
                //     // Redirect to the sign-in page with an error message
                //     // window.location.href = "/sign-in";
                //     alert("Error")
                // } else {
                //     console.log(error); // Displaying the error in the console for debugging
                // }
            }
        });
    });


    function decodeJwtResponse(token){
        let base64Url  = token.split('.') [1]
        let base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
        let jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c){
            return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
        }).join(''));
        return JSON.parse(jsonPayload)
    }

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    window.onSignIn = googleUser => {
        var user = decodeJwtResponse(googleUser.credential);
        if(user){
            $.ajax({
                url: 'google/login',
                method: 'post',
                data: {email : user.email},
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                beforeSend:function(){},
                success:function(response){
                     if(response.status === 'success'){
                        alert("Login Successfuly!");
                        window.location.href = '/dashboard';
                     } else{
                        alert(response.message);

                     }
                },
                error:function(xhr, status, error){
                    alert(xhr.responseJSON.message);
                }

                
            });
        }else{
            $('#message').text('An error occured.Please try again later!');
        }

    }
</script>
<script src="https://accounts.google.com/gsi/client" async defer></script>
