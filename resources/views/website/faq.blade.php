@extends('layout.mainlayout',['active_page' => 'about us'])

@section('title',__('About Us'))

@section('content')



<!-- <div class="page-banner-with-full-image item-bg3">
    <div class="container">
        <div class="page-banner-content-two">
            <h2>MMD - FAQ</h2>
            <ul>
                <li>
                    <a href="index.html">Home</a>
                </li>
                <li>FAQ</li>
            </ul>
        </div>
    </div>
</div> -->

<div class="container">

<section class="faqs-area bg-ffffff ptb-50">
            <div class="container">
                <div class="section-title">
                    <h2>We Are Here To <span>Answer</span> Your Questions</h2>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="faq-accordion">
                            <div class="accordion">

                            @if(count($faqCategories))
                                @foreach($faqCategories as $faqCategory)
                                    @php $faqs = App\Models\RadiologyCategory::whereStatus(1)->where('category_id',$faqCategory->id)->orderBy('sort','ASC')->get(); @endphp
                                    <h5 class="text-left text-bold">{{$faqCategory->name}}</h5>
                                    @foreach($faqs as $faq)
                                        <div class="accordion-item">
                                            <div class="accordion-title">
                                                <i class='bx bxs-down-arrow'></i>
                                                {{$faq->name}}
                                            </div>
                
                                            <div class="accordion-content">
                                                <p> {!! clean($faq->description) !!}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach  
                            @else
                                @php $faqs = App\Models\RadiologyCategory::whereStatus(1)->whereNotNull('category_id')->get(); @endphp
                                @foreach($faqs as $faq)
                                    <div class="accordion-item">
                                        <div class="accordion-title">
                                            <i class='bx bxs-down-arrow'></i>
                                            {{$faq->name}}
                                        </div>
            
                                        <div class="accordion-content">
                                            <p> {!! clean($faq->description) !!}</p>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            @foreach($faqsWithoutCategories as $faq)
                                <div class="accordion-item">
                                    <div class="accordion-title">
                                        <i class='bx bxs-down-arrow'></i>
                                        {{$faq->name}}
                                    </div>
        
                                    <div class="accordion-content">
                                        <p> {!! clean($faq->description) !!}</p>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        </div>
                    </div>

                   
                </div>
            </div>

            <div class="faqs-main-shape">
                <img src="assets/images/faq-shape.png" alt="image">
            </div>
        </section>

</div>

<div class="content p-5">
    <div class="container">
        
    </div>
</div>
@endsection

