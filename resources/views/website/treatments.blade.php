@extends('layout.mainlayout',['active_page' => 'about us'])

@section('title',__('List'))

@section('content')


<div class="container">

<section class="faqs-area bg-ffffff ptb-100">
            <div class="container">
                <div class="section-title">
                    <h2>{{$activepage}}</h2>
                    
                </div>

                <div class="row">
                   


                        @foreach($treatments as $treatment)
                         <div class="col-lg-6">
                            <div class="faq-accordion">
                            <div class="accordion">
                                <div class="accordion-item">
                                    <div class="accordion-title active">
                                       
                                        {{$treatment->name}}

                                        <a href="{{url('/resources')}}?category={{$treatment->id}}" class="btn pull-right" style="float: right;padding-top: 0px;">Read More</a>
                                    </div>
        
                                    
                                </div>

                                  
                                </div>
                            </div>
                        </div>
                        @endforeach    
                             

                   
                </div>
            </div>

        </section>

</div>

<div class="content p-5">
    <div class="container">
        
    </div>
</div>
@endsection

