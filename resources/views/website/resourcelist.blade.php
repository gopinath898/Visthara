@extends('layout.mainlayout',['active_page' => 'about us'])

@section('title',__('List'))

@section('content')


<div class="container">

<section class="faqs-area bg-ffffff ptb-100">
            <div class="container">
                <div class="section-title">
                    <h2>Resources</h2>
                    
                </div>

                <div class="row">
                   


                       
                        <div class="col-lg-6">
                            <div class="card">

                                
                                <a href="{{url('/specializations')}}" class="btn pull-right" style="float: right;padding-top: 0px;font-size: 20px;">
                                 <img src="assets/images/special.png" alt="image" style="width: 20%;">
                                Specializations<br>
                                <small>Click Here Read More</small></a>
                            </div>
                        </div>


                        <div class="col-lg-6">
                            <div class="card">

                                <a href="{{url('/treatment-list')}}" class="btn pull-right" style="float: right;padding-top: 0px;font-size: 20px;">

                                 <img src="assets/images/expert.png" alt="image" style="width: 20%;">

                                Area of Expertise
                                <br>
                             <small>Click Here Read More</small></a>
                            </div>
                        </div>
                        
                             

                   
                </div>
            </div>

        </section>

</div>

<div class="content p-5">
    <div class="container">
        
    </div>
</div>
@endsection

