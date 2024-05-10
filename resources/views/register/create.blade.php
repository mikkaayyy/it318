<x-layout bodyClass="">

    <div>
        <div class="container position-sticky z-index-sticky top-0">
            <div class="row">
                <div class="col-12">
                    <!-- Navbar -->
                    <x-navbars.navs.guest signin='login' signup='register'></x-navbars.navs.guest>
                    <!-- End Navbar -->
                </div>
            </div>
        </div>
        <main class="main-content mt-0">
    <section>
        <div class="page-header min-vh-100">
            <div class="container">
                <div class="row">
                    <section class="min-vh-100 mb-5">
                        <div class="page-header align-items-start min-vh-100 pt-10 pb-50 mx-1 border-radius-lg" style="background-image: url('../assets/img/hair-salon-background.jpg'); background-size: cover;">

                            <span class="mask bg-gradient-dark opacity-6"></span>
                            <div class="container">
                                <div class="row justify-content-center align-items-center mt-lg-n5 mt-md-n11 mt-n10">
                                    <div class="col-xl-5 col-lg-5 col-md-7">
                                        <div class="card z-index-0">
                                            <div class="card-header text-center pt-4">
                                                <!-- <h5>Register Here</h5> -->
                                            </div>
                                            <div class="row px-xl-7 px-sm-4 px-3">
                                            
                                                <h3 class="mb-5 pb-2 pb-md-0 mb-md-5 text-center">Registration Form</h3>
                                              
                                                    @csrf
                                                    <div class="mt-2 position-relative text-center">
                                                        <p class="text-sm font-weight-bold mb-2 text-secondary text-border d-inline z-index-2 bg-white px-3">

                                                        </p>
                                                    </div>
                                            </div>
                                            <form role="form text-left" id="frmRegister" method="POST" action="{{ route('register.store') }}">


                                            <div class="card-body">
                                                <!-- <form role="form text-left" id="frmRegister"> -->
                                   <p id = "error-message">
                               @csrf
                                 <div class="mb-3">
                             <input type="text" class="form-control" placeholder="Name" name="name" id="name" aria-label="Name" aria-describedby="name" value="{{ old('name') }}">
                           @error('name')
                          <p class="text-danger text-xs mt-2">{{ $message }}</p>
                  @enderror
                </div>
                <div class="mb-3">
                  <input type="email" class="form-control" placeholder="Email" name="email" id="email" aria-label="Email" aria-describedby="email-addon" value="{{ old('email') }}">
                  @error('email')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                  @enderror
                </div>
                <div class="mb-3">
                  <input type="password" class="form-control" placeholder="Password" name="password" id="password" aria-label="Password" aria-describedby="password-addon">
                  @error('password')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                  @enderror
                </div>
                <div class="form-check form-check-info text-left">
                  <input class="form-check-input" type="checkbox" name="agreement" id="flexCheckDefault" checked>
                  <label class="form-check-label" for="flexCheckDefault">
                    I agree the <a href="javascript:;" class="text-dark font-weight-bolder">Terms and Conditions</a>
                  </label>
                  @error('agreement')
                    <p class="text-danger text-xs mt-2">First, agree to the Terms and Conditions, then try register again.</p>
                  @enderror
                </div>
                <div class="text-center">
                  <button type="button" id="btnRegister"class="btn bg-gradient-dark w-100 my-4 mb-2">Sign up</button>
                </div>
                <p class="text-sm mt-3 mb-0 text-center">Already have an account? <a href="login" class="text-dark font-weight-bolder">Sign-up</a></p>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="/assets/js/script.js"></script>



 

<


    @push('js')
    <script src="{{ asset('assets') }}/js/jquery.min.js"></>
    <script>
        $(function() {
    
        var text_val = $(".input-group input").val();
        if (text_val === "") {
          $(".input-group").removeClass('is-filled');
        } else {
          $(".input-group").addClass('is-filled');
        }
    });
    </script>
    @endpush
</x-layout>