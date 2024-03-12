@extends('layout.mainlayout',['active_page' => 'about us'])

@section('title',__('About Us'))

@section('content')


<section class="about-area bg-ffffff ptb-100">
            <div class="container">
                <div class="row align-items-center">

                    <div class="col-lg-6">
                        <div class="about-main-content">
                            <h3>Know About Us</h3>

                            <!-- <div class="about-content-image">
                                <img src="assets/images/about/about-2.jpg" alt="image">

                               

                                
                            </div> -->
                            <p>{!! clean($about_us) !!}</p>

                           <!--  <div class="row">
                                <div class="col-lg-6 col-sm-6">
                                    <div class="about-information">
                                        <i class="flaticon-trophy"></i>
                                        <h5> Years</h5>
                                        <span>Experience</span>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6">
                                    <div class="about-information">
                                        <i class="flaticon-customer"></i>
                                        <h5></h5>
                                        <span>Clients</span>
                                    </div>
                                </div>
                            </div> -->

                            
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="about-main-image">
                            <img src="web/assets/images/aboutus.jpg" alt="image">

                            <!-- <div class="about-shape about-wrap">
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
                </div>
            </div>
        </section>




<div class="container p-5">
    <div class="container">
            <div class="row align-items-center">
                 <h2 style="text-align: center;padding: 24px;margin-bottom: 24px;">Our Team</h2>
                </div>
            <div class="row">
            <div class="col-lg-4 col-md-6">
                        <div class="single-coaches">
                            <div class="image">
                                <img src="{{asset('/images/upload/Iqra.PNG')}}" >
    
                                
                            </div>
    
                            <div class="content" style="text-align: center;">
                                <h3>
                                    Iqra 
                                </h3>


                                <h5 style="padding: 5px;"> Co-Founder</h5>
                                

                               
                                <p>
                                    
                                   

                                    <b>Bachelor of Science in Psychology </b><br>

                                    State University of New York at Buffalo, USA <br>

                                    <b>  Master’s of Science in Clinical Psychology </b> 

                                     <br>

                                    California Lutheran University, USA
                                    <br>

                                     <b> MPhil in Clinical Psychology<br>
                                    India </b>
                                    <br>

                                </p>
                            

                                   
                                    

                                   

                                   
                            </div>

                                
                            

                            
                        </div>
                    </div>
                

            <div class="col-lg-4 col-md-6">
                        <div class="single-coaches">
                            <div class="image">
                                <img src="{{asset('/images/upload/Taha.jpg')}}" >
    
                                
                            </div>
    
                            <div class="content" style="text-align: center;">
                                <h3>
                                    Mirza Taha Iqbal Beg 
                                </h3>


                                <h5 style="padding: 5px;"> Co-Founder </h5>
                                <h6>Head of HR</h6>
                               
                                <p>
                                    
                                   <b>BSc in Business Management</b>
                                   <br>
                                    Queen Mary, University of London, London
                                     <br>
                                    <b> MSc Human Resource Management and Employment Relations</b>
                                     <br>
                                    University of Warwick, United Kingdom



                                </p>
                            
                                   
                            </div>

                                
                            

                            
                        </div>
                    </div>


            <div class="col-lg-4 col-md-6">
                        <div class="single-coaches">
                            <div class="image">
                                <img src="{{asset('/images/upload/Shahooda.jpg')}}" style="width: 270px;">
    
                                
                            </div>
    
                            <div class="content" style="text-align: center;">
                                <h3>
                                    Shahooda Kadri 
                                </h3>


                                <h5 style="padding: 5px;"> Co-Founder</h5>
                                <h6>Head of Finance</h6>
                               
                                <p>
                                    
                                   <b>Bachelor’s in Business Administration (Silver medalist)</b>

                                    Amity University, India
                                    <br>

                                    <b> MSc Accounting and Finance</b> 

                                    University of Leeds, United Kingdom
                                    <br>
                                     <b>MSc Economics and Finance</b> <br>

                                     Durham University, United Kingdom



                                </p>
                            
                                   
                            </div>

                                
                            

                            
                        </div>
                    </div>
            </div>
    </div>
</div>
@endsection
