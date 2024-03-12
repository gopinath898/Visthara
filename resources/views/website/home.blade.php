@extends('layout.mainlayout', ['active_page' => 'home'])

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/gallerySheet.css') }}">
@endpush


@section('title', __('Home'))

@section('content')


    <div class="site-body">


        <div class="main-banner-area" style="background-image: url(web/assets/images/main-banner/banner-bg-1.jpg);">
            <div class="main-banner-item">
                <div class="container">
                    <div class="main-banner-content">
                        <h1>An Extraordinary Life Starts With Mental health care</h1>
                        <p>Your journey towards a healthy lifestyle starts with us.</p>

                        <div class="banner-btn">

                            @if (auth()->check())
                                <a href="{{ url('/subscriptions') }}" class="default-btn">Get Started </a>
                            @else
                                <a href="{{ url('/patient-login') }}" class="default-btn">Get Started </a>
                            @endif
                            <!--   <a href="services.html" class="optional-btn">Our Services <i class="flaticon-repairing-service"></i></a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- <div class="site-hero overflow-hidden position-relative d-md-block d-none">
                                            <img src="{{ url('images/upload/' . $setting->banner_image) }}" alt="">
                                            <div class="btn-appointment ms-auto mt-sm-0 mt-3 position-absolute">
                                                <a class="btn btn-link text-center mt-0" target="_blank" href="{{ $setting->banner_url }}" role="button">{{ __('Consult Now') }}</a>
                                            </div>
                                        </div> -->





        <div class="container-fluid">
            <!-- <div class="content mx-auto my-3">
                                                <div class="d-flex w-100 describe justify-content-between flex-md-row flex-column py-3 ">
                                                    <div class="consult">
                                                        <h2>{{ __('What are you looking for?') }}</h2>
                                                    </div>
                                                </div>




                                                <div class="row row-cols-1 row-cols-lg-3 row-cols-sm-2 g-0 ">
                                                    @foreach ($banners as $banner)
                                                        <a href="{{ $banner->link }}" target="_blank">
                                                            <div class="col">
                                                                <div class="card h-100 border-0 {{ $loop->iteration != 1 ? 'ml-2' : '' }} looking-card">
                                                                    <div class="img-wrapper rounded-3 overflow-hidden">
                                                                        <img src="{{ $banner->fullImage }}" alt="...">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div> -->


            <section class="about-area ptb-100" style="padding-top: 40px;">
                <div class="container">
                    <div class="row text-center" style="display: block;">
                        <img src="images/scroll.png" style="width: 100px">
                    </div>
                    <div class="row align-items-center">
                        <div class="section-title">
                            <h2>About MyMindDoctor </h2>

                        </div>
                        <div class="col-lg-6">
                            <div class="about-main-image">
                                <img src="web/assets/images/aboutus.jpg" alt="image">

                                <!-- <div class="about-shape">
                                                                <div class="shape-1">
                                                                    <img src="assets/images/about/shape-1.png" alt="image">
                                                                </div>

                                                                <div class="shape-2">
                                                                    <img src="assets/images/about/shape-2.png" alt="image">
                                                                </div>

                                                                <div class="shape-3">
                                                                    <img src="assets/images/about/shape-3.png" alt="image">
                                                                </div>

                                                                <div class="shape-4">
                                                                    <img src="assets/images/about/shape-4.png" alt="image">
                                                                </div>

                                                                <div class="shape-5">
                                                                    <img src="assets/images/about/shape-5.png" alt="image">
                                                                </div>
                                                            </div> -->
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="about-main-content">


                                <div class="row mb-4">


                                    <a href="{{ url('show-therapist') }}" class="sub-title">
                                        <h4>Therapists/Psychologists/Counsellors</h4>
                                    </a>
                                    <br>

                                </div>

                                <!-- <div class="about-content-image">
                                                                <img src="assets/images/about/about-2.jpg" alt="image">

                                                                <a href="" class="sub-title"><h4>Psychiatrists (Medication management)  Coming Soon...</h4></a>

                                                               
                                                            </div> -->
                                <p style="text-align: justify;">We are a mental health platform based out of India with a
                                    vision of providing innovative and comprehensive solutions to mental health issues. Our
                                    core team comprises of Clinical Psychologists trained and educated from the USA. </p>
                                <p style="text-align: justify;">Our aim is to destigmatize mental health conversations and
                                    cultivating a friendly atmosphere where people feel free to share their thoughts,
                                    feelings and emotions.</p>

                                <div class="row">
                                    <div class="col-lg-4 col-sm-4">
                                        <img src="{{ asset('assets/img/facetime-button.png') }}"
                                            style="background-color: #00adab;padding: 10px;border-radius: 13px;float: left;width: 51px;position: absolute;z-index: 99999;margin-left: 20px;margin-top: 29px;">
                                        <div class="about-information">

                                            <h6>Video</h6>
                                            <!-- <span>Online Video Call</span> -->
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-sm-4">

                                        <img src="{{ asset('assets/img/telephone-call.png') }}"
                                            style="background-color: #00adab;padding: 10px;border-radius: 13px;float: left;width: 51px;position: absolute;z-index: 99999;margin-left: 20px;margin-top: 29px;">
                                        <div class="about-information">

                                            <h6>Audio</h6>
                                            <!-- <span>Online Audio Call</span> -->
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-sm-4">

                                        <img src="{{ asset('assets/img/speech.png') }}"
                                            style="background-color: #00adab;padding: 10px;border-radius: 13px;float: left;width: 51px;position: absolute;z-index: 99999;margin-left: 20px;margin-top: 29px;">

                                        <div class="about-information">

                                            <h6>Chat</h6>
                                            <!-- <span>Online Chat Window</span> -->
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="about-btn">
                                                                <a href="about.html" class="default-btn">More About Us <i class="flaticon-user"></i></a>
                                                            </div> -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="about-main-shape">
                    <img src="assets/images/about/line-shape.png" alt="image">
                </div>
            </section>

            <div class="services-area ptb-100">
                <div class="container">
                    <div class="section-title">
                        <h2>What Services We Provide</h2>
                    </div>

                    <div class="tab services-list-tab">
                        <ul class="tabs">
                            <li>
                                <a href="#">
                                    <i class="flaticon-imagination"></i>
                                    <span>Individual Therapy</span>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="flaticon-bipolar"></i>
                                    <span>Couples Therapy</span>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="flaticon-extrovert"></i>
                                    <span>Family Therapy</span>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="flaticon-anger"></i>
                                    <span>Child Therapy</span>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="flaticon-anger"></i>
                                    <span>Psychiatry</span>
                                </a>
                            </li>


                        </ul>

                        <div class="tab_content">
                            <div class="tabs_item">
                                <div class="row align-items-center">
                                    <div class="col-lg-6">
                                        <div class="services-tab-image">
                                            <img src="web/assets/images/indi.jpg" alt="image">

                                            <!-- <div class="services-tab-shape">
                                                                            <div class="shape-1">
                                                                                <img src="assets/images/services/shape-1.png" alt="image">
                                                                            </div>
                                            
                                                                            <div class="shape-2">
                                                                                <img src="assets/images/services/shape-2.png" alt="image">
                                                                            </div>
                                            
                                                                            <div class="shape-3">
                                                                                <img src="assets/images/services/shape-3.png" alt="image">
                                                                            </div>
                                            
                                                                            <div class="shape-4">
                                                                                <img src="assets/images/services/shape-4.png" alt="image">
                                                                            </div>

                                                                            <div class="circle-shape">
                                                                                <img src="assets/images/services/circle-shape.png" alt="image">
                                                                            </div>
                                                                        </div> -->
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="services-tab-content">
                                            <div class="row mb-4">

                                                <h4 class="sub-title">Individual therapy</h4>
                                            </div>
                                            <p style="text-align: justify;">Individual therapy aims to provide a
                                                confidential and mindful space where individuals can talk about their
                                                feelings, thoughts, and actions in a way that helps them work through their
                                                issues and problems on their own. Individuals may have different goals and
                                                mental health difficulties that impact certain areas of their lives. The
                                                therapist encourages the client to talk about their problematic thoughts,
                                                feelings, and behaviors to formulate a plan for addressing their issues and
                                                provide support, guidance, and insight throughout the process. Some
                                                individual therapies are CBT, ACT, interpersonal psychotherapy, DBT, etc.
                                            </p>


                                            <!-- <div class="services-quote">
                                                                            <i class="flaticon-close"></i>
                                                                        </div> -->

                                            <div class="services-btn">
                                                <a href="{{ url('/show-therapist') }}" class="default-btn">Find Therapist
                                                    <i class="flaticon-search"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tabs_item">
                                <div class="row align-items-center">
                                    <div class="col-lg-6">
                                        <div class="services-tab-image">
                                            <img src="web/assets/images/couple.jpg" alt="image">

                                            <!-- <div class="services-tab-shape">
                                                                            <div class="shape-1">
                                                                                <img src="assets/images/services/shape-1.png" alt="image">
                                                                            </div>
                                            
                                                                            <div class="shape-2">
                                                                                <img src="assets/images/services/shape-2.png" alt="image">
                                                                            </div>
                                            
                                                                            <div class="shape-3">
                                                                                <img src="assets/images/services/shape-3.png" alt="image">
                                                                            </div>
                                            
                                                                            <div class="shape-4">
                                                                                <img src="assets/images/services/shape-4.png" alt="image">
                                                                            </div>

                                                                            <div class="circle-shape">
                                                                                <img src="assets/images/services/circle-shape.png" alt="image">
                                                                            </div>
                                                                        </div> -->
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="services-tab-content">
                                            <div class="row mb-4">
                                                <!-- <img src="assets/images/services/flower.jpg" alt="image"> -->

                                                <h4 class="sub-title">Couples Therapy</h4>
                                            </div>
                                            <p style="text-align: justify;">Couples therapy aims to help couples improve
                                                their relationship by exploring various causes of their problems, including
                                                communication problems, infidelity, intimacy issues, and significant life
                                                events. It also helps couples identify and work together to achieve their
                                                relationship goals. The therapist helps couples identify the conflicts, find
                                                ways to build and strengthen their bond and understand each other's needs,
                                                emotions, and behaviors to improve the quality of their relationship. Some
                                                effective psychotherapy includes emotionally focused therapy, the Gottman
                                                method, cognitive behavior therapy, couples counseling, etc.</p>

                                            <!-- <div class="services-quote">
                                                                            <i class="flaticon-close"></i>
                                                                        </div> -->

                                            <div class="services-btn">
                                                <a href="{{ url('/show-therapist') }}" class="default-btn">Find Therapist
                                                    <i class="flaticon-search"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tabs_item">
                                <div class="row align-items-center">
                                    <div class="col-lg-6">
                                        <div class="services-tab-image">
                                            <img src="web/assets/images/family.jpg" alt="image">

                                            <!-- <div class="services-tab-shape">
                                                                            <div class="shape-1">
                                                                                <img src="assets/images/services/shape-1.png" alt="image">
                                                                            </div>
                                            
                                                                            <div class="shape-2">
                                                                                <img src="assets/images/services/shape-2.png" alt="image">
                                                                            </div>
                                            
                                                                            <div class="shape-3">
                                                                                <img src="assets/images/services/shape-3.png" alt="image">
                                                                            </div>
                                            
                                                                            <div class="shape-4">
                                                                                <img src="assets/images/services/shape-4.png" alt="image">
                                                                            </div>

                                                                            <div class="circle-shape">
                                                                                <img src="assets/images/services/circle-shape.png" alt="image">
                                                                            </div>
                                                                        </div> -->
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="services-tab-content">
                                            <div class="row mb-4">


                                                <h4 class="sub-title">Family Therapy</h4>
                                            </div>
                                            <p style="text-align: justify;">Family therapy aims to help family members
                                                improve their relationships, resolve conflicts and improve their quality of
                                                life by focusing on specific issues affecting their mental health and
                                                functioning. The therapist's role in family therapy is to assist family
                                                members in understanding each other's thoughts and feelings, strengthening
                                                relationships, and improving communication by providing insights and helping
                                                them learn how to work together as a team to resolve conflicts within the
                                                family. Depending on the family's needs, various family psychotherapy
                                                techniques can be used, such as family systems therapy, structural family
                                                therapy, narrative family therapy, etc.</p>

                                            <!--  <div class="services-quote">
                                                                            <i class="flaticon-close"></i>
                                                                        </div> -->

                                            <div class="services-btn">
                                                <a href="{{ url('/show-therapist') }}" class="default-btn">Find Therapist
                                                    <i class="flaticon-search"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tabs_item">
                                <div class="row align-items-center">
                                    <div class="col-lg-6">
                                        <div class="services-tab-image">
                                            <img src="web/assets/images/child.jpg" alt="image">

                                            <!-- <div class="services-tab-shape">
                                                                            <div class="shape-1">
                                                                               
                                                                            </div>
                                            
                                                                            <div class="shape-2">
                                                                                <img src="assets/images/services/shape-2.png" alt="image">
                                                                            </div>
                                            
                                                                            <div class="shape-3">
                                                                                <img src="assets/images/services/shape-3.png" alt="image">
                                                                            </div>
                                            
                                                                            <div class="shape-4">
                                                                                <img src="assets/images/services/shape-4.png" alt="image">
                                                                            </div>

                                                                            <div class="circle-shape">
                                                                                <img src="assets/images/services/circle-shape.png" alt="image">
                                                                            </div>
                                                                        </div> -->
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="services-tab-content">
                                            <div class="row mb-4">


                                                <h4 class="sub-title">Child Therapy</h4>
                                            </div>
                                            <p style="text-align: justify;">Child/adolescent therapy aims to support
                                                children and teenagers struggling with emotional, behavioral, and mental
                                                health challenges by providing psychoeducation, a safe and supportive
                                                environment to express feelings, and exploring their experiences to work
                                                through any psychological struggle. It includes conversations between a
                                                mental health therapist and a child, adolescent, or family member about
                                                selecting and applying the best approaches and techniques to enhance
                                                therapeutic outcomes. Some effective child and adolescent psychotherapies
                                                include CBT, DBT, behavioral therapy, child counseling, play therapy, anger
                                                management therapy, etc.</p>

                                            <!-- <div class="services-quote">
                                                                            <i class="flaticon-close"></i>
                                                                        </div> -->

                                            <div class="services-btn">
                                                <a href="{{ url('/show-therapist') }}" class="default-btn">Find Therapist
                                                    <i class="flaticon-search"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tabs_item">
                                <div class="row align-items-center">
                                    <div class="col-lg-6">
                                        <div class="services-tab-image">
                                            <img src="web/assets/images/main.jpg" alt="image">

                                            <!-- <div class="services-tab-shape">
                                                                            <div class="shape-1">
                                                                                <img src="assets/images/services/shape-1.png" alt="image">
                                                                            </div>
                                            
                                                                            <div class="shape-2">
                                                                                <img src="assets/images/services/shape-2.png" alt="image">
                                                                            </div>
                                            
                                                                            <div class="shape-3">
                                                                                <img src="assets/images/services/shape-3.png" alt="image">
                                                                            </div>
                                            
                                                                            <div class="shape-4">
                                                                                <img src="assets/images/services/shape-4.png" alt="image">
                                                                            </div>

                                                                            <div class="circle-shape">
                                                                                <img src="assets/images/services/circle-shape.png" alt="image">
                                                                            </div>
                                                                        </div> -->
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="services-tab-content">
                                            <div class="row mb-4">


                                                <h4 class="sub-title">Psychiatry</h4>
                                            </div>
                                            <p style="text-align: justify;">Psychiatry is a division of medicine that
                                                primarily emphasizes biological aspects of mental health by focusing on
                                                diagnosing, treating, and preventing mental conditions by using various
                                                medications and psychological interventions in collaboration with mental
                                                health experts. Psychiatrists are medical doctors in mental health who work
                                                with individuals, families, and groups' concerns to promote overall
                                                well-being.</p>


                                            <!-- <div class="services-quote">
                                                                            <i class="flaticon-close"></i>
                                                                        </div> -->

                                            <!-- <div class="services-btn">
                                                                            <a href="{{ url('/show-therapist') }}" class="default-btn">Find Theraphy <i class="flaticon-search"></i></a>
                                                                        </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>









            <section class="products-area ptb-100" style="display: none;">
                <div class="container-fluid">
                    <div class="section-title">
                        <h2>Healing Steps</h2>
                        <p class="section-content">We help you get the best psychologists/therapists/counselors that are a
                            right fit based on your issues.</p>
                    </div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="contact-info-box" style="background: #FFF;padding: 15px">
                                    <div class="icon">
                                        <!-- <i class="flaticon-phone-call"></i> -->
                                        <h6 style="text-align: center;">Step 1</h6>


                                    </div>


                                    <p style="text-align: center;font-size: 18px;">Choose from one of our therapists</p>


                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="contact-info-box" style="background: #FFF;padding: 15px">
                                    <div class="icon">

                                        <h6 style="text-align: center;">Step 2</h6>
                                    </div>

                                    <p style="text-align: center;font-size: 18px;">Choose a suitable package</p>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="contact-info-box" style="background: #FFF;padding: 15px">
                                    <div class="icon">

                                        <h6 style="text-align: center;">Step 3</h6>
                                    </div>

                                    <p style="text-align: center;font-size: 18px;">Get Started in your healing journey</p>
                                </div>
                            </div>
                        </div>


                    </div>

                    <p style="text-align: center;">If you’re not sure which therapist to choose from, we can help you match
                        with your right fit based on your issues. <b>Call on 9596079035</b></p>
                </div>


            </section>


            <section class="main-banner-item services-area ptb-100" style="padding-top: 80px;
padding-bottom: 80px;">

                <div class="container-fluid">

                    <div style="text-align: center;padding: 24px;">
                        <h2 style="color: #504f4f;padding-bottom: 50px;">Why Choose Us</h2>
                        <!-- <p>We provide access to the best psychologists from all over India.</p> -->
                        <div class="row new-card">

                            <div class=" col-md-6" style="background: #FFF;">

                                <img src="assets/images/certi.png" alt="image" style="width: 20%;">
                                <h5>Licensed and certified therapists</h5>
                                <p> We have RCI licensed Clinical psychologists and therapists who have been personally
                                    vetted by us.</p>


                                <img src="assets/images/multi.png" alt="image" style="width: 20%;">
                                <h5>Multi Lingual therapists</h5>

                                <p>Therapists from all over India fluent in over 15+ languages</p>

                                <img src="assets/images/cost.png" alt="image" style="width: 20%;">
                                <h5>Cost Effective</h5>
                                <p>Variety of affordable packages to choose from</p>


                                <img src="assets/images/book.png" alt="image" style="width: 24%;padding-top: 28px;">
                                <h5>Convenient</h5>
                                <p>
                                    You can book sessions based around your schedule</p>
                            </div>

                            <div class="col-md-6" style="background: #FFF;">


                                <img src="assets/images/secure.png" alt="image" style="width: 20%;">
                                <h5>Security of the Platform</h5>
                                <p style="min-height: 42px;">Provide You High Cloud Security & Data Loss Prevention</p>

                                <img src="assets/images/access.png" alt="image" style="width: 19%;">
                                <h5>Access to the best psychologists</h5>
                                <p style="min-height: 42px;">We provide access to the best psychologists from all over
                                    India.</p>

                                <img src="assets/images/24.png" alt="image" style="width: 20%;">
                                <h5>24/7 availability</h5>
                                <p>Dedicated to providing a 24/7 online therapy service</p>


                                <img src="assets/images/resources.png" alt="image" style="width: 20%;">
                                <h5>Resources</h5>
                                <p>Access to information about psychology and mental health</p>

                            </div>


                            <!-- <div class="new-card col-md-5" style="background: #FFF;">

                                            
                                    </div>

                                    <div class="new-card col-md-5" style="background: #FFF;">
                                            
                                    </div>

                                    <div class="new-card col-md-5" style="background: #FFF;">
                                           
                                    </div>
                                    <div class="new-card col-md-5" style="background: #FFF;">
                                            
                                    </div> -->
                        </div>
                    </div>
                </div>

            </section>




            <section class="products-area ptb-100" style="display: none;">
                <div class="container-fluid">
                    <div class="section-title">
                        <h2>What Therapy Specializations We Provide</h2>

                    </div>
                    <div class="tab treatment-list-tab">
                        <ul class="tabzs">
                            <li class="hide"></li>


                            @forelse ($categories as $category)
                                <li>
                                    <a href="{{ url('/resources') }}?category={{ $category->id }}"
                                        style="padding: 25px 15px 25px 15px;min-height: 92px;">
                                        <span class="bolder">{{ $category->name }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>


                <div class="services-btn" style="text-align: center;color: #ffffff;">
                    <a href="resources" class="default-btn"
                        style="text-align: center;color: #ffffff;padding-left: 48px;">View All Therapy Specializations</a>
                </div>



                <div class="products-main-shape">
                    <img src="assets/images/products/shape-1.png" alt="image">
                </div>
            </section>





            <div class="services-area ptb-100" style="display: none;">
                <div class="container">
                    <div class="section-title">
                        <h2>RESOURCES</h2>
                    </div>

                    <div class="tab treatment-list-tab">
                        <ul class="tabzs">
                            <li class="hide"></li>

                            @forelse ($treatments as $treatment)
                                <li>
                                    <a href="{{ url('show-therapist') }}" style="padding: 25px 15px 25px 15px;">

                                        <!--  <img class="flaticon-imagination" src="{{ $treatment->fullImage }}" style="width: 48px;float: left;padding-top: 6px;"> -->
                                        <span class="bolder">{{ $treatment->name }}</span>
                                    </a>
                                </li>
                            @endforeach


                        </ul>


                    </div>
                </div>

                <div class="services-btn" style="text-align: center;color: #ffffff;">
                    <a href="treatment-list" class="default-btn"
                        style="text-align: center;color: #ffffff;padding-left: 48px;">View All RESOURCES</a>
                </div>
            </div>


            <section class="gallerySection" style="overflow-x: hidden;">
                <div class="galleryContainer">
                    <div class="gallery">
                        <img draggable="false" src="https://myminddoctor.com/images/upload/643517010cebe.jpg" alt="big rocks with some trees">
                        <img draggable="false" src="https://myminddoctor.com/images/upload/643cf8af17910.JPG" alt="sime pink flowers">
                        <img draggable="false" src="https://myminddoctor.com/images/upload/643674283ef84.jpg"
                            alt="a waterfall, a lot of tree and a great view from the sky">
                        <img draggable="false" src="https://myminddoctor.com/images/upload/6435761d99b71.jpeg" alt="a cool landscape">
                        <img  draggable="false"src="https://myminddoctor.com/images/upload/643cf110e8223.jpeg"
                            alt="inside a town between two big buildings">
                        <img draggable="false" src="https://myminddoctor.com/images/upload/6459ead697c81.jpg"
                            alt="a great view of the sea above the mountain">
                    </div>
                    <div class=" contentContainer">
                        <div class="content">

                            <h2 class="heading-xl">
                                Highly qualified team of expert psychologists licensed from Rehabilitation Council Of India.
                            </h2>
                                <p>
                                    All our expersts are carefully vetted through a rigorous selection
                                    process. Trained and experienced in all psychotherapy techniques.
                                    We aim to provide you with a unique therapeutic experience by
                                    matching you with a therapist tailored to your preferences and
                                    needs.
                                </p>

                                <p>
                                    Choose from a wide variety of licensed experts from all parts of the
                                    country with various areas of specialisations and therapeutic
                                    expertise.
                                    WIth English, Hindi and other various regional languages, book a
                                    session at your convenience today!
                                </p>
                            <div class="btn-container">
                                <a class="btn btn-primary" href="{{ url('/show-therapist') }}"">Get matched to your
                                    therapist</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            {{-- <section class="products-area ptb-100">
                <div class="container-fluid">
                    <div class="section-title">
                        <h2>Our Experts</h2>
                    </div>
                    <div class="row about-main-content">
                        @forelse ($doctors as $doctor)
                            <div class="col-lg-4 col-md-6 col-sm-12 col-12 px-3">
                                <div class="single-coaches parent-section non-relative">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-4 p-0">
                                            <div class="image pt-4 px-1">
                                                <a
                                                    href="{{ url('therapist_profile/' . $doctor['id'] . '/' . Str::slug($doctor['name'])) }}">
                                                    <img
                                                        class="br-100 content-image" src="{{ $doctor['fullImage'] }}"
                                                        alt="team-image"></a>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-sm-8 col-8 p-0">
                                            <div class="content">
                                                <h5>
                                                    <a
                                                        href="{{ url('therapist_profile/' . $doctor['id'] . '/' . Str::slug($doctor['name'])) }}">{{ $doctor['name'] }}</a>
                                                </h5>
                                                <p class="content-p">{{ ucwords($doctor['designation'] ?? '') }}</p>
                                                <div class="content-p2">

                                                    <p>
                                                        <strong class="bx bxs-star"></strong>
                                                        <b>SPECIALIZES IN: </b>
                                                        @php $listcat= implode(',', $doctor->expertiseArea);@endphp

                                                        @if (strlen($listcat) > 60)
                                                            {!! substr($listcat, 0, 60) !!}....
                                                        @else
                                                            {{ $listcat }}
                                                        @endif
                                                    </p>
                                                    <p>
                                                        <strong class="bx bxs-message-rounded-dots"></strong>
                                                        <b>SPEAKS: </b>
                                                        {{ implode(',', $doctor->language) }}
                                                    </p>
                                                    <p>
                                                        <strong class="bx bx-loader-circle"></strong>
                                                        <b>SESSIONS MODE: </b>
                                                        Audio, Video, Chat
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex">
                                            <div class="col-5 mb-2">
                                                <p class="content-p f-12 mb-0">Next Available Slot:</p>
                                                @if (isset($doctor['todaytimeSlot'][0]['start_time']))
                                                    <a href="#"
                                                        class="f-10">{{ $doctor['todaytimeSlot'][0]['start_time'] }}</a>
                                                @endif
                                                @if (isset($doctor['todaytimeSlot'][1]['start_time']))
                                                    <a href="#"
                                                        class="f-10">{{ $doctor['todaytimeSlot'][1]['start_time'] }}</a>
                                                @endif
                                            </div>
                                            <div class="col-7">
                                                <a href="{{ url('therapist_profile/' . $doctor['id'] . '/' . Str::slug($doctor['name'])) }}"
                                                    class="content-btn btn btn-primary bookbtn rounded-pill">{{ __('View Profile') }}
                                                </a>
                                            </div>

                                        </div>
                                    </div>


                                </div>

                            </div>
                        @empty
                            <div class="w-100 text-center">
                                <i class='bx bxs-user-plus noData'></i>
                                <br>
                                <h6 class="mt-3">{{ __('Therapists Not Available.') }}</h6>
                            </div>
                        @endforelse
                    </div>

                    <div class="row">

                        <div class="services-btn" style="text-align: center;color: #ffffff;">
                            <a href="therapy/therapy_signup" class="default-btn"
                                style="text-align: center;color: #ffffff;">Join Network </a>
                        </div>

                    </div>




                </div>
            </section> --}}


            <div class="row" style="padding-top: 20px;background-color: #ffffff;color: #086f85;font-weight: bold;">

                <marquee width="60%" direction="left" height="50px">
                    “AN EXTRAORDINARY LIFE starts with mental health care ------------ Your journey towards a healthy
                    lifestyle starts with us.”
                </marquee>
            </div>

            <section class="blog-area pb-70" style="/*background: #f4f4f4;*/padding-top:50px;display: none;">
                <div class="container">
                    <div class="section-title">
                        <h2>Dive Into Our Blog</h2>
                        <p>Read top articles from therapy experts.</p>
                    </div>

                    <div class="row justify-content-center">
                        @foreach ($blogs as $blog)
                            <div class="col-lg-4 col-md-6">
                                <div class="single-blog-item">
                                    <div class="blog-image">
                                        <a href="blog-details.html"><img src="{{ url($blog->full_image) }}"
                                                alt="image"></a>
                                        <div class="tag">{{ Carbon\Carbon::parse($blog['created_at'])->format('M d') }}
                                        </div>

                                    </div>

                                    <div class="blog-content">

                                        <div class="meta">
                                            {{ $blog->blog_ref }}
                                        </div>


                                        <div class="row">
                                            <b>
                                                @if (strlen($blog->title) > 50)
                                                    {!! substr(clean($blog->title), 0, 50) !!}....
                                                @else
                                                    {!! clean($blog->title) !!}
                                                @endif
                                            </b>
                                        </div>

                                        <h3>
                                            <a href="blog-details.html">{!! clean($blog->desc) !!}</a>
                                        </h3>


                                        <div class="blog-btn">
                                            <a href="{{ url('blogs/' . $blog->id . '/' . Str::slug($blog->title)) }}"
                                                class="default-btn">Read More <i class="flaticon-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        @endforeach
                    </div>
                </div>
            </section>

            <!-- <div class="contact-ban">
                                            <div class="Footer-ban h-100 mx-auto">
                                                <div class="row g-4 h-100">
                                                    <div class="col-lg-6  h-100">
                                                        <div class="position-relative h-100 footer-img">
                                                            <img src="{{ url('assets/img/banner.png') }}" class="position-absolute" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6  h-100">
                                                        <div class="footer-ban-text h-100 d-flex">
                                                            <div class="my-auto">
                                                                <h3>{{ __('Download the ') }}{{ $setting->business_name }} {{ __('app') }}</h3>
                                                                <p>{{ __('Get in touch with the top-most expert Specialist Therapists for an accurate consultation on the Doctro. Connect with Therapists, that will be available 24/7 right for you.') }}</p>
                                                                <h4>{{ __('Get the link to download the app') }}</h4>

                                                                <div class="d-flex download-app">
                                                                    <div class="me-2">
                                                                        <a href="{{ $setting->playstore }}" target="_blank"><img src="{{ asset('assets/static/google_play.webp') }}" alt=""></a>
                                                                    </div>
                                                                    <div class="">
                                                                        <a href="{{ $setting->appstore }}" target="_blank"><img src="{{ asset('assets/static/apple_store.webp') }}" alt=""></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
        </div>
    @endsection
