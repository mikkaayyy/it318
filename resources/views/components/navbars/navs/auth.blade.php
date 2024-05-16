@props(['titlePage'])

<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $titlePage }}</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">{{ $titlePage }}</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                {{-- <div class="input-group input-group-outline">
                    <label class="form-label">Type here...</label>
                    <input type="text" class="form-control">
                </div> --}}
            </div>
            <form method="POST" action="{{ route('logout') }}" class="d-none" id="logout-form">
                @csrf
            </form>
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                        <i class="fa fa-user me-sm-1"></i>
                        <span class="d-sm-inline d-none"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sign
                            Out</span>
                    </a>
                </li>
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
                <li class="nav-item px-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0">
                        <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                    </a>
                </li>
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0 position-relative" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell cursor-pointer"></i>
                    </a>
                    <ul id="notificationList" class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                        aria-labelledby="dropdownMenuButton">
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>

    $(document).ready(function(){
        getUnreadnotification()
        getAllnotification()
    })

    $('#dropdownMenuButton').on('click',()=>{
        $.ajax({
            method: 'get',
            url: 'notification/readall',
            dataType: 'json',
            success: function(response) {
                $('#notifnum').addClass('d-none')
            }
        })
    })

    function getUnreadnotification(){
        $.ajax({
            method: 'get',
            url: 'notification/getunread',
            dataType: 'json',
            success: function(response) {
                if(response>0){
                    $('#dropdownMenuButton').append(`
                        <div id="notifnum" class="bg-danger position-absolute text-white w-100 d-flex justify-content-center rounded-circle text-xs" style="padding:2px 10px; top:-10px; right:-15px">
                           ${response}
                        </div>
                    `)
                }
            }
        })
    }
    function getAllnotification(){
        $.ajax({
            method: 'get',
            url: 'notification/get',
            dataType: 'json',
            success: function(response) {
                console.log(response)
                if(response){
                    response.forEach(element => {
                        $('#notificationList').append(`
                            <li>
                                <a class="dropdown-item border-radius-md" href="javascript:;">
                                    <div class="d-flex py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="text-sm font-weight-normal mb-1">
                                                ${element.notifcationBody}
                                            </h6>
                                         
                                        </div>
                                    </div>
                                </a>
                            </li>
                        `)
                    });
                    
                }
            }
        })
    }
</script>
