<Sty
<div class="navbar-area">
            <div class="main-responsive-nav" style="margin: 8px;">
                <div class="container">
                    <div class="main-responsive-menu">
                        <div class="logo" style="width: 100px;">
                            <a href="{{url('/')}}">
                                <img src="{{ url('images/upload/'.$setting->company_logo)}}" class="black-logo" alt="image">
                                <img src="{{ url('images/upload/'.$setting->company_logo)}}" class="white-logo" alt="image">
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-navbar">
                <div class="container-fluid">
                    <nav class="navbar navbar-expand-md navbar-light">
                        <a class="navbar-brand" href="{{url('/')}}">
                            <img src="{{ url('images/upload/'.$setting->company_logo)}}" class="black-logo" alt="image" width="100px">
                            <img src="{{ url('images/upload/'.$setting->company_logo)}}" class="white-logo" alt="image" width="100px">
                        </a>

                        <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                            <ul class="navbar-nav m-auto" style="margin-right: 35px !important;">
                                

                                <!-- <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        Services 
                                        <i class='bx bx-caret-down'></i>
                                    </a>

                                    <ul class="dropdown-menu">
                                        <li class="nav-item">
                                            <a href="services.html" class="nav-link">Services</a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="services-details.html" class="nav-link">Services Details</a>
                                        </li>
                                    </ul>
                                </li> -->

                                

                                <li class="nav-item">
                                    <a href="{{url('/show-therapist')}}" class="nav-link">Find Therapist</a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('/free-report') }}" class="nav-link">Free Report</a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('/how-it-works') }}" class="nav-link">How it Works</a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('/subscriptions') }}" class="nav-link">Pricing</a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('resources') }}" class="nav-link">Resources</a>
                                </li>


                                <li class="nav-item">
                                    <a href="{{ url('faq') }}" class="nav-link">FAQ</a>
                                </li>
    
                                <!-- <li class="nav-item">
                                    <a href="{{ url('contact') }}" class="nav-link">Contact</a>
                                </li> -->
                            </ul>

                            <div class="others-options d-flex align-items-center">
                                <div class="option-item">

                                    <a href="{{url('therapy/therapy_signup')}}" class="nav-link" style="font-size: 16px;font-weight: 400;">Join Network </a>




                                    <!-- <div class="cart-btn">
                                        <a href="cart.html">
                                            <i class='flaticon-shopping-cart'></i>
                                            <span>2</span>
                                        </a>
                                    </div> -->
                                </div>

                                <!-- <div class="option-item">

                                    <a href="{{url('/patient-register')}}" class="nav-link" style="font-size: 16px;font-weight: 400;">Register </a>
                                </div> -->

                                <!-- <div class="option-item">
                                    <div class="search-box">
                                        <i class='flaticon-search'></i>
                                    </div>
                                </div> -->
                     @if (auth()->check())
                    <a class="nav-link menu-link drop-link dropdown-toggle more-drop" href="javascript:void(0)" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> 
                        <img src="{{ url('images/upload/'.auth()->user()->image) }}" class="rounded-circle avtar" alt=""> {{auth()->user()->name}}
                    </a>
                    <ul class="dropdown-menu" style="top:66%;left: 88%;">
                        <!-- <li class="nav-item">
                            <img src="{{ url('images/upload/'.auth()->user()->image) }}" class="rounded-circle avtar me-2" alt="">
                            <div>
                                <p>{{ auth()->user()->name }}</p>
                                <p class="text-muted">{{ __('Client') }}</p>
                            </div>
                        </li> -->
                        <li class="nav-item"><a class="dropdown-item " href="{{ url('user_profile') }}">{{ __('Dashboard') }}</a>
                        </li>
                        <li class="nav-item"><a class="dropdown-item"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="javascript:void(0)">{{ __('logout') }}</a></li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @else

                <div class="navbar-btn">
                <!-- <a class="navbar-btnnav-link menu-link drop-link dropdown-toggle more-drop default-btn" href="javascript:void(0)" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #ffffff !important;min-width: 100px">   <i class="flaticon-pointer"></i>
                        Login
                    </a>
                    <ul class="dropdown-menu" style="top:66%;left: 88%;">
                       
                        <li class="nav-item"><a class="dropdown-item " href="{{ url('patient-login') }}">{{ __('Client Login') }}</a>
                        </li>

                        <li class="nav-item"><a class="dropdown-item " href="{{ url('therapy/therapy_login') }}">{{ __('Therapist Login') }}</a>
                        </li>
                        
                    </ul> -->

                    <a class="navbar-btnnav-link menu-link  default-btn" href="{{url('/patient-login')}}"  style="color: #ffffff !important;min-width: 100px;text-align: center;padding: 10px 10px 10px 10px;">   <!-- <i class="flaticon-pointer"></i> -->
                        Log In
                    </a>
                    <a class="navbar-btnnav-link menu-link  default-btn" href="{{url('/patient-register')}}"  style="color: #ffffff !important;min-width: 100px;text-align: center;padding: 10px 10px 10px 10px;background-color: #079492;">   <!-- <i class="flaticon-plus"></i> -->
                        Sign Up
                    </a>
                     </div>
                                <!-- <div class="option-item">
                                    <div class="navbar-btn">
                                        <a href="{{ url('patient-login') }}" class="default-btn"> <i class="flaticon-pointer"></i> Login</a>
                                    </div>
                                </div> -->

                    @endif
                            </div>
                        </div>
                    </nav>
                </div>
            </div>

            <div class="others-option-for-responsive">
                <div class="container">
                    <div class="dot-menu">
                        <div class="d-flex align-items-center login avtar-wrapper order-xl-3 order-4 dropdown ms-auto">
                @if (auth()->check())
                <a class="nav-link menu-link drop-link dropdown-toggle more-drop" href="javascript:void(0)" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="right: 0px;left: auto;text-align: center;text-indent: 0px;font-size: 18px;position: relative; top: -20px !important;"> 
                    <img src="{{ url('images/upload/'.auth()->user()->image) }}" class="rounded-circle avtar" alt="" style="right: 0px;left: auto;text-align: center;text-indent: 0px;font-size: 18px;position: relative;">
                    </a>
                    <ul class="dropdown-menu u-d profile-detail" aria-labelledby="offcanvasNavbarDropdown">
                        <li class="dropdown-item d-flex align-items-center">
                            <img src="{{ url('images/upload/'.auth()->user()->image) }}" class="rounded-circle avtar me-2" alt="">
                            <div>
                                <p>{{ auth()->user()->name }}</p>
                                
                            </div>
                        </li>
                        <li><a class="dropdown-item " href="{{ url('user_profile') }}">{{ __('Dashboard') }}</a>
                        </li>
                        <li><a class="dropdown-item"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="javascript:void(0)">{{ __('logout') }}</a></li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @else

                <ul class="navbar-nav menubar  align-items-xl-center flex-grow-1">

                    

                    <li class="nav-item menu-link d-flex flex-column">

                       <!--  <a class="btn btn-link text-center mt-0" target="_blank" href="{{ url('patient-login') }}" role="button" style="padding: 10px 20px">Login</a> -->

                    </li>
                </ul>
                     <ul class="navbar-nav menubar  align-items-xl-center flex-grow-1 ">
                        <li class="nav-item dropdown ms-xl-auto">
                            <a class="nav-link drop-link menu-link dropdown-toggle more-drop" href="javascript:void(0)" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="right: 0px;left: auto;text-align: center;text-indent: 0px;font-size: 18px;position: relative; top: -18px !important;border: 1px solid gray;border-radius: 5px;">{{ __('Login') }}</a>
                            <ul class="dropdown-menu u-d" aria-labelledby="offcanvasNavbarDropdown">
                                <li><a class="dropdown-item" target="_blank" href="{{ url('patient-login') }}">{{ __('Client Login ') }}</a></li>
                                <li><a class="dropdown-item" href="{{ url('therapy/therapy_login') }}">{{ __('Therapist Login') }}</a></li>
                            </ul>
                        </li>
                    </ul>
                @endif
                
            </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>

<!-- <div class="page-header sticky-header d-flex align-items-center">
    <div class="container-xl d-flex">

        <nav class="navbar content w-100 m-auto navbar-light navbar-expand-xl">
            <a class="navbar-brand order-xl-1 order-2" href="{{ url('/') }}">
                
                <img src="{{ url('images/upload/'.$setting->company_logo)}}" width="100px" alt="">
            </a>

            <button class="navbar-toggler  order-xl-2 order-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarOffcanvasLg" aria-controls="navbarOffcanvasLg">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="offcanvas offcanvas-start order-xl-2 order-1 " tabindex="-1" id="navbarOffcanvasLg" aria-labelledby="navbarOffcanvasLgLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">{{ $setting->business_name }}</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>


                <div class="offcanvas-body" style="display: block;float: right;">
                    <ul class="navbar-nav menubar  align-items-xl-center flex-grow-1" style="float: right;">
                        <li class="nav-item nav-select {{ $active_page == 'doctors' ? 'active' : '' }}">
                            <a class="nav-link menu-link d-flex flex-column" href="{{ url('show-doctors') }}">{{ __('Find Therapists') }}
                             <span>{{ __('Book an appointment') }}</span>
                            </a>
                        </li>


                        <li class="nav-item nav-select {{ $active_page == 'pharmacy' ? 'active' : '' }}">
                            <a class="nav-link menu-link d-flex flex-column" href="{{ url('/user_about_us') }}">About Us
                            </a>
                        </li>


                       <li class="nav-item nav-select {{ $active_page == 'pharmacy' ? 'active' : '' }}">
                            <a class="nav-link menu-link d-flex flex-column" href="{{ url('/all-pharmacies') }}">{{__('Pharmacy')}}
                                <span>{{__('Medicines & Health Product')}}</span>
                            </a>
                        </li>

                        <li class="nav-item nav-select {{ $active_page == 'lab_test' ? 'active' : '' }}">
                            <a class="nav-link menu-link d-flex flex-column " href="{{ url('/labs') }}">{{__('Lab tests')}}
                                <span>{{__('Book tests & checkup')}}</span>
                            </a>
                        </li> 

                        <li class="nav-item nav-select {{ $active_page == 'offer' ? 'active' : '' }}">
                            <a class="nav-link menu-link d-flex flex-column " href="{{ url('all-offers') }}">{{ __('Offers') }}
                              <span>{{ __('Coupens And Discount') }}</span> 
                            </a>
                        </li>
                        <li class="nav-item nav-select {{ $active_page == 'blog' ? 'active' : '' }}">
                            <a class="nav-link menu-link d-flex flex-column " href="{{ url('resources') }}">{{ __('Blog') }}
                                <span>{{ __('Blogs') }}</span> 
                            </a>
                        </li>

                        <li class="nav-item nav-select {{ $active_page == 'offer' ? 'active' : '' }}">
                            <a class="nav-link menu-link d-flex flex-column " href="{{ url('all-offers') }}">Join Our Network
                               <span>{{ __('Coupens And Discount') }}</span> 
                            </a>
                        </li>

                    <li class="nav-item nav-select {{ $active_page == 'offer' ? 'active' : '' }}">
                            <a class="nav-link menu-link d-flex flex-column " href="{{ url('all-offers') }}">Register Now
                               <span>{{ __('Coupens And Discount') }}</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="d-flex align-items-center login avtar-wrapper order-xl-3 order-4 dropdown ms-auto">
                @if (auth()->check())
                    <a class="nav-link menu-link drop-link dropdown-toggle more-drop" href="javascript:void(0)" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> 
                        <img src="{{ url('images/upload/'.auth()->user()->image) }}" class="rounded-circle avtar" alt="">
                    </a>
                    <ul class="dropdown-menu u-d profile-detail" aria-labelledby="offcanvasNavbarDropdown">
                        <li class="dropdown-item d-flex align-items-center">
                            <img src="{{ url('images/upload/'.auth()->user()->image) }}" class="rounded-circle avtar me-2" alt="">
                            <div>
                                <p>{{ auth()->user()->name }}</p>
                                <p class="text-muted">{{ __('Client') }}</p>
                            </div>
                        </li>
                        <li><a class="dropdown-item " href="{{ url('user_profile') }}">{{ __('Dashboard') }}</a>
                        </li>
                        <li><a class="dropdown-item"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="javascript:void(0)">{{ __('logout') }}</a></li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @else

                <ul class="navbar-nav menubar  align-items-xl-center flex-grow-1">

                    

                    <li class="nav-item menu-link d-flex flex-column">

                        <a class="btn btn-link text-center mt-0" target="_blank" href="{{ url('patient-login') }}" role="button" style="padding: 10px 20px">Login</a>

                    </li>
                </ul>
                     <ul class="navbar-nav menubar  align-items-xl-center flex-grow-1 ">
                        <li class="nav-item dropdown ms-xl-auto">
                            <a class="nav-link drop-link menu-link dropdown-toggle more-drop" href="javascript:void(0)" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ __('For Providers') }}</a>
                            <ul class="dropdown-menu u-d" aria-labelledby="offcanvasNavbarDropdown">
                                <li><a class="dropdown-item" target="_blank" href="{{ url('doctor/doctor_login') }}">{{ __('Login For Doctors') }}</a></li>
                                <li><a class="dropdown-item" href="{{ url('patient-login') }}">{{ __('Login For Clients') }}</a></li>
                            </ul>
                        </li>
                    </ul>
                @endif
                <div class="ms-2 cart me-xl-0 me-2 ">
                    <a href="{{ url('cart') }}" class="d-flex position-relative"><i class='bx bxs-cart-alt'></i>
                        <p class="position-absolute d-flex align-items-center justify-content-center tot_cart">{{ Session::has('cart') ? count(Session::get('cart')) : 0 }}</p>
                    </a>
                </div>
            </div>
        </nav>
    </div>
</div> -->