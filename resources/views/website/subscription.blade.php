@extends('layout.mainlayout',['active_page' => 'offer'])

@section('title',__('Subscription'))

@section('content')

<div class="full-content">
    <div class="site-body pricing-background pt-50">
        <div class="container">
            @if (count($subscriptions))
            <div class="row">
                <section class="pricing-area pt-60 pb-50">
                    <div class="container" style="padding-left: 9%;padding-right: 9%;">
                        <div class="section-title">
                            <h5 class="h5">Let's find the right plan for you</h5>
                        </div>
                        <div class="row justify-content-center">
                            @foreach ($subscriptions as $offer)
                            @if($offer->name != "1 Session")
                            <div class="col-lg-4 col-md-4">
                                <div class="single-pricing-table new-single-pricing-table new-pricing-table">
                                    <div class="pricing-header ">
                                    
                                        <h6>{{ ucfirst($offer->name) }}</h6>
                                    </div>

                                    <div class="row" style="text-align: center;display: block;">


                                        <img src="images/{{$offer->name}}.png" style="@if(ucfirst($offer->name)=='3 Sessions') width: 26%;opacity: 0.7; @else width: 28%; @endif">
                                    </div>

                                    <div class="pricing-btn">
                                    @if($offer->discount > 0) 
                                        <del><h5 style=""><span>Rs.</span>{{$offer->price}}</h5></del>

                                        <strong>{{$offer->discount}}% Discount</strong>

                                        <h5><span>Rs.</span>{{round($offer->finalAmount)}}</h5>
                                    @else

                                        <h5><span>Rs.</span>{{$offer->price}}</h5>
                                    @endif

                                    </div>
                                    <div class="pricing-features mt-4">
                                    </div>

                                    <div class="pricing-features pricing-features-description mt-4">
                                        <div style="color: black;min-height: 76px;">
                                            {!! clean($offer->first_description) !!}
                                        </div>
                                            <br>
                                         <p>

                                            {!! clean($offer->description) !!}
                                           
                                        </p>
                                    </div>

                                    @if (auth()->check())

                                        <div class="pricing-btn">
                                            <a href="{{ url('buy-package/'.'?package_id='.Str::slug($offer->id)) }}" class="subscription-pricing-button btn btn-primary rounded-pill">Buy Now</a>
                                        </div>

                                    @else

                                        <div class="pricing-btn">
                                        <a href="{{ url('patient-login') }}" class="subscription-pricing-button btn btn-primary rounded-pill">Buy Now</a>
                                    </div>


                                    @endif
                                </div>
                            </div>
                            @endif
                            @endforeach
                            @foreach ($subscriptions as $offer)
                            @if($offer->name == "1 Session")
                            <div class="single-session-subscription text-center col-lg-12 col-md-12">
                                <div>
                                    <p style="font-size:16px;">Or get a single session at Rs.{{$offer->price}}</p>
                                    @if (auth()->check())
                                    <a href="{{ url('buy-package/'.'?package_id='.Str::slug($offer->id)) }}" class="btn btn-outline-dark">Buy Now</a>
                                    @else
                                    <a href="{{ url('patient-login') }}" class="btn btn-outline-dark">Buy Now</a>
                                    @endif
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                        
                    </div>  
                </section>
            </div>
            @else
                <div class="w-100 text-center">
                    <i class='bx bxs-offer noData' ></i>
                    <br>
                    <h4 class="mt-2">{{__('Offeres Not Availabel.')}}</h4>
                </div>
            @endif

            <div class="w-100 text-center text-white">

                <h6 class="text-white"> We will connect you to the best of mental health professionals, specialized in your areas of concern.</h6>
                <p style="margin-bottom:0px;" class="text-white">Still have questions</p>
                <p style="margin-bottom:0px;" class="text-white">Don’t stress, take a deep breath and give us a call at 9596079035</p>
                <p style="margin-bottom:0px;" class="text-white">OR</p>
                <a style="font-weight: bold;font-size: 14px;" href="{{url('/faq')}}" class="text-white">Click here to refer to FAQs</a>
            </div>
            <br>
        </div>
    </div>
</div>
@endsection
