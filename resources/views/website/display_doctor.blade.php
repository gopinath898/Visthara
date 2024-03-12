<!-- <div class="">
    <div class="content mx-auto">
        <div class="ps-xl-0 ps-3 mt-3">
            <h3>{{ count($doctors) }} &nbsp;{{ __('Therapists available') }}</h3>
            <p class="mt-2">{{ __('Book Your Appointment with easy Way') }}</p>
        </div>
    </div>
</div>
-->
<style>
    .ui-datepicker-trigger {
        width: 20px;
        position: relative;
        left: 204px;
        bottom: 32px;
    }



    .container-main-banner {
        margin-left: 8%;
        max-width: 1520px;
        margin-inline-start: 0px;
        margin-inline-end: 0px;
        /* background-image: url(https://www.felicity.care/assets/images/our-counsellors-banner.png); */
        background-image: url(web/assets/images/main-banner/banner-bg-1.jpg);
        background-repeat: no-repeat;
        background-size: cover;
        background-position: 50%;
        display: flex;
        align-items: center;
        height: 350px;
        color: #fff
    }



    .container-main-banner .contentContainer {
        color: #ffffff;
        font-weight: 600;
        font-size: 25px;
        margin-bottom: 0.5rem;
        line-height: 1.2;
        margin-top: 0;
        margin-left: 8%;
        max-width: 1520px;

    }

    .container-main-banner h2 {
        font-weight: 600;
        color: #ffffff;
    }


    .container-main-banner p {
        /* margin: 25px 25px; */
        margin: 20px 0;
        font-size: 1.4rem;
        font-weight: 450;
        color: #ffffff;
        font-size: 18px;
    }

    .container-main-banner button {
        -webkit-text-size-adjust: 100%;
        -webkit-tap-highlight-color: transparent;
        padding: 1.2vh 3.2vh;
        border-radius: 0.8vh;
        background: #026b81;
        background-image: initial;
        background-position-x: initial;
        background-position-y: initial;
        background-size: initial;
        background-repeat-x: initial;
        background-repeat-y: initial;
        background-attachment: initial;
        background-origin: initial;
        background-clip: initial;
        background-color: #026b81;
        font-size: 2.4vh;
        display: inline-block;
        color: #fff;
        cursor: pointer;
        border: none;
    }

    .container-main-banner .banner {
        display: flex;
        align-items: center;
        border-radius: none;
    }

    section.banner {
        border-radius: 1px;
        height: 285px;
        margin-top: 0px !important;
        color: #fff;
    }
</style>

<section class="container-main-banner banner">
    <div class="contentContainer" class="container-main-banner">
        <div>
            <h2> We have the best professionals - <br>
                licensed and verified, who can <br> you heal! </h2>
            <p>
                Not sure how to choose a counselling
                therapist?
            </p>
            <a href="{{ url('/contact') }}" class="">
                <button>Get a recommendation</button>
            </a>
        </div>
    </div>
</section>

<section class="coaches-area pt-100 pb-70">
    <div class="container">
        {{-- <div class="section-title">
            @if (isset($subscriptions) && $subscriptions)
                <h6>Package Selected {{ $subscriptions->name }}</h6>
                <h2>Choose a<span>Therapist to Proceed</span></h2>
            @else
                <h2>Find <span>Therapist</span></h2>
            @endif
            <p>My Mind Doctor provides access to RCI licensed Clinical Psychologists, RCI licensed Associate
                Clinical Psychologists, RCI licensed Rehabilitation Psychologists, Clinical Child &amp; Adolescent
                Psychologists, Industrial/Organizational Psychologists, Counseling Psychologists, Marriage &amp;
                Family Counselors, Guidance &amp; Career Counselors and Substance Abuse Counselors to
                provide the best possible resources.</p>
        </div> --}}

        <div class="d-flex align-content-center mb-3">
            <h6 class="p-2" style="white-space:nowrap;"><b>{{ __('Filter By') }}</b></h6>

            <div class="filter-options">
                <form action="{{ url('/show-therapist') }}" method="GET" class="row">
                    <div class="col-3" id="language">
                        <select name="language[]" class="select2 @error('language') is-invalid @enderror"
                            style="width:100%" data-placeholder="Languages" multiple>
                            @foreach ($languages as $language)
                                <option value="{{ $language->id }}">{{ $language->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-3" id="specialization">
                        <select name="specialisation[]"
                            class="select2 form-control @error('specialization') is-invalid @enderror"
                            data-placeholder="Specializations" style="width:100%" multiple>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ in_array($category->id, json_decode($specializations->specialisation_id ?? '') ?? []) ? 'selected' : '' }}>
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3" id="specialization">
                        <input class="form-control datePicker @error('date') is-invalid @enderror" id="date"
                            min="{{ Carbon\Carbon::now(env('timezone'))->format('Y-m-d') }}" name="date"
                            onkeypress="return false;">
                    </div>
                    <button class="col-1 btn btn-outline-primary filter-search-button" type="submit">Filter</button>
                </form>
            </div>
        </div>

        <div class="scrolling-pagination">
            <div class="row align-items-center">

                @if (count($doctors) > 0)
                    @foreach ($doctors as $doctor)
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
                                                    @php $listcat= implode(',', $doctor['expertiseArea']);@endphp

                                                    @if (strlen($listcat) > 60)
                                                        {!! substr($listcat, 0, 60) !!}....
                                                    @else
                                                        {{ $listcat }}
                                                    @endif
                                                </p>
                                                <p>
                                                    <strong class="bx bxs-message-rounded-dots"></strong>
                                                    <b>SPEAKS: </b>
                                                    {{ implode(',', $doctor['language']) }}
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
                                            <a href="{{ url('therapist_profile/' . $doctor['id'] . '/' . Str::slug($doctor['name'])) }}@if (isset($request->session_id)) ?session_id={{ $request->session_id }} @endif"
                                                class="content-btn btn btn-primary rounded-pill">{{ __('Book Now') }}
                                            </a>
                                        </div>

                                    </div>
                                </div>


                            </div>

                        </div>
                    @endforeach
                @else
                    <div class="w-100 text-center">
                        <i class='bx bxs-user-plus noData'></i>
                        <br>
                        <h6 class="mt-3">{{ __('Therapist Not Available.') }}</h6>
                    </div>
                @endif
                {{ $doctors->appends(request()->query())->links() }}
            </div>
        </div>

        <div class="row text-center">
            <p>Choose Us to Help You</p>
            <p href="" class="col-md-3"></p>
            <a href="{{ url('/patient-login') }}" class=" default-btn col-md-3">Sign Up</a>

            <a href="{{ url('/subscriptions') }}" class="default-btn col-md-3">Prices</a>

        </div>
    </div>
</section>

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>
    <script type="text/javascript">
        $('ul.pagination').hide();
        $(function() {
            $('.scrolling-pagination').jscroll({
                autoTrigger: true,
                padding: 0,
                nextSelector: '.pagination li.active + li a',
                contentSelector: 'div.scrolling-pagination',
                callback: function() {
                    $('ul.pagination').remove();
                }
            });
        });
    </script>
@endsection
