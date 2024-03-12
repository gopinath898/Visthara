@extends('layout.mainlayout', ['active_page' => 'about us'])

@section('title', __('About Us'))

@section('content')

    <link rel="stylesheet" href="{{ url('assetsfinal/style.css') }}">

    <style type="text/css">
        label {
            padding: 5px;
        }

        .outer-border {
            width: 800px;
            height: 950px;
            padding: 20px;
            text-align: center;
            margin-left: 21%;
        }

        .inner-dotted-border {
            width: 90%;
            height: 900px;
            padding: 20px;
            text-align: center;
        }

        .certification {
            font-size: 50px;
            font-weight: bold;
            color: #663ab7;
        }

        .certify {
            font-size: 25px;
        }

        .name {
            font-size: 30px;
            color: green;
        }

        .fs-30 {
            font-size: 30px;
        }

        .fs-20 {
            font-size: 20px;
        }

        .mt-100 {
            /*margin-top: 200px;*/
        }

        .progress {
            width: 150px;
            height: 150px !important;
            float: left;
            line-height: 150px;
            background: none;
            margin: 20px;
            box-shadow: none;
            position: relative;
        }

        .progress:after {
            content: "";
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 12px solid #fff;
            position: absolute;
            top: 0;
            left: 0;
        }



        @if ($totalscore < 16)

            .progress.yellow .progress-right .progress-bar {
                animation: loading-3 1.8s linear forwards;
            }




        @elseif($totalscore > 15 and $totalscore < 31)


            .progress.yellow .progress-right .progress-bar {
                animation: loading-1 1.8s linear forwards;
            }



        @else
            .progress.yellow .progress-right .progress-bar {
                animation: loading-1 1.8s linear forwards;
            }

            .progress.yellow .progress-left .progress-bar {
                animation: loading-3 1.8s linear forwards;
            }

        @endif


        .progress>span {
            width: 50%;
            height: 100%;
            overflow: hidden;
            position: absolute;
            top: 0;
            z-index: 1;
        }

        .progress .progress-left {
            left: 0;
        }

        .progress .progress-bar {
            width: 100%;
            height: 100%;
            background: none;
            border-width: 12px;
            border-style: solid;
            position: absolute;
            top: 0;
        }

        .progress .progress-left .progress-bar {
            left: 100%;
            border-top-right-radius: 80px;
            border-bottom-right-radius: 80px;
            border-left: 0;
            -webkit-transform-origin: center left;
            transform-origin: center left;
        }

        .progress .progress-right {
            right: 0;
        }

        .progress .progress-right .progress-bar {
            left: -100%;
            border-top-left-radius: 80px;
            border-bottom-left-radius: 80px;
            border-right: 0;
            -webkit-transform-origin: center right;
            transform-origin: center right;
            animation: loading-1 1.8s linear forwards;
        }

        .progress .progress-value {
            width: 90%;
            height: 90%;
            border-radius: 50%;
            background: #017188;
            font-size: 24px;
            color: #fff;
            line-height: 135px;
            text-align: center;
            position: absolute;
            top: 5%;
            left: 5%;
        }

        .progress.blue .progress-bar {
            border-color: #21e5e2;
        }

        .progress.blue .progress-left .progress-bar {
            animation: loading-2 1.5s linear forwards 1.8s;
        }

        .progress.yellow .progress-bar {
            border-color: #21e5e2;
        }






        @keyframes loading-1 {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(180deg);
                transform: rotate(180deg);
            }
        }

        @keyframes loading-2 {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(144deg);
                transform: rotate(144deg);
            }
        }

        @keyframes loading-3 {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(135deg);
                transform: rotate(135deg);
            }
        }
    </style>

    {{-- <div class="page-banner-with-full-image item-bg3">
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
    </div> --}}


    <div class="container">

        <style>
            div.scrollmenu {
                /*background-color: #333;*/
                overflow: auto;
                white-space: nowrap;
            }

            div.scrollmenu a {
                display: inline-block;
                color: white;
                text-align: center;
                padding: 14px;
                text-decoration: none;
            }

            div.scrollmenu a:hover {
                background-color: #777;
            }
        </style>
        </head>

        <body>



            <div class="leftBox">

                <h2 class="mainHeading">{{ $category->name }}</h2>
                <h5 class="subHeading">Here are your results:</h5>

                <div class="rangeContainer" >
                    <div class="progress yellow">
                        <span class="progress-left">
                            <span class="progress-bar"></span>
                        </span>
                        <span class="progress-right">
                            <span class="progress-bar"></span>
                        </span>
                        <div class="progress-value">

                            @if ($totalscore < 16)
                                Low
                            @elseif($totalscore > 15 and $totalscore < 31)
                                Moderate
                            @else
                                High
                            @endif
                        </div>
                    </div>
                </div>

                <br>
                <div class="textContainer">
                    <div class="textContainerFont">

                        @if ($totalscore < 16)
                            <div class="textContainer">

                                <h5 class="textContainerHeading"><br>Your scores have indicators of high levels of symptoms.
                                </h5>
                                <h5 class="rightContentContainer">



                                    {{ $category->low }}

                                </h5>


                            </div>
                        @elseif($totalscore > 15 and $totalscore < 31)
                            <div class="textContainer">
                                <h5 class="textContainerHeading"><br>Your score reveals a moderate number of symptoms.</h5>
                                <h5 class="rightContentContainer">


                                    {{ $category->moderate }}

                                </h5>


                            </div>
                        @else
                            <div class="textContainer">
                                <h5 class="textContainerHeading"><br>Your scores have indicators of high levels of symptoms.
                                </h5>
                                <h5 class="rightContentContainer">

                                    {{ $category->high }}

                                </h5>


                            </div>
                        @endif

                    </div>
                </div>


            </div>
            <div class="rightBox">
                <div class="rightBoxContainer">


                    @if ($totalscore < 16)
                        <h3
                            style="
                        color: black;
                        font-weight: 600;
                        ">
                            Recommended Course of Action:</h3>
                        <h4 class="rightContentContainer">

                            {{ $category->rec_low }}</h4>
                    @elseif($totalscore > 15 and $totalscore < 31)
                        <h3
                            style="
                        color: black;
                        font-weight: 600;
                        ">
                            Recommended Course of Action:</h3>
                        <h4 class="rightContentContainer">
                            {{ $category->rec_moderate }}</h4>
                    @else
                        <h3
                            style="
                        color: black;
                        font-weight: 600;
                        ">
                            Recommended Course of Action:</h3>
                        <h4 class="rightContentContainer">
                            {{ $category->rec_high }}</h4>
                    @endif

                    <div class="rightContentContainer">
                        <!-- <div class="rightHeading">
                                            <h2>Psychiatry with MMD</h2>
                                            <h5>Find expert support for your concerns by consulting an
                                                MMD psychiatrist.</h5>
                                        </div> -->



                        <div class="rightBody">
                            <h5>Book a session with our Therapist</h5>




                            <div class="scrollmenu" style="margin: 1rem 0">

                                @foreach ($doctors as $doctor)
                                    <a
                                        href="{{ url('therapist_profile/' . $doctor->id . '/' . Str::slug($doctor->name)) }}">

                                        <div class="doctor">
                                            <div class="doctorImageContainer">
                                                <img src="{{ $doctor->fullImage }}" width="80px" height="112px"
                                                    draggable="false" class="cover">
                                            </div>

                                            <div class="doctorContent">
                                                <h5 class="doctorName">
                                                    {{ $doctor->name }}
                                                </h5>
                                                <h6 class="doctorOtherContent">
                                                    <svg stroke="currentColor" fill="none" stroke-width="2"
                                                        viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"
                                                        color="#657E47" height="12" width="12"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        style="color: rgb(101, 126, 71);">
                                                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                                        <path
                                                            d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z">
                                                        </path>
                                                    </svg>
                                                    {{ ucwords($doctor->designation ?? '') }}
                                                </h6>

                                                <h6 class="doctorOtherContent">
                                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                                        viewBox="0 0 24 24" color="#657E47" height="12" width="12"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        style="color: rgb(101, 126, 71);">
                                                        <g>
                                                            <path fill="none" d="M0 0h24v24H0z"></path>
                                                            <path
                                                                d="M7.291 20.824L2 22l1.176-5.291A9.956 9.956 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10a9.956 9.956 0 0 1-4.709-1.176zm.29-2.113l.653.35A7.955 7.955 0 0 0 12 20a8 8 0 1 0-8-8c0 1.334.325 2.618.94 3.766l.349.653-.655 2.947 2.947-.655z">
                                                            </path>
                                                        </g>
                                                    </svg>
                                                    {{ implode(',', $doctor->language) }}
                                                </h6>
                                            </div>
                                        </div>

                                    </a>
                                @endforeach
                            </div>


                            <div wrap="nowrap" width="auto" cursor="unset" opacity="1" class="docBtnContainer">
                                <a style="width: 46%" href="{{ url('show-therapist') }}" class="btn default-btn">BOOK A
                                    SESSION</a>
                            </div>







                            <!--  <h5 class="highlightHeading">HIGHLIGHTS</h5>
                                            <div class="highLightContainer">
                                                <div class="highLight">
                                                    >
                                                    <h5 class="highLightText">Speak your mind.
                                                        Our therapists are fluent in over 8 languages.</h5>
                                                </div>
                                                <div class="highLight">
                                                   >
                                                    <h5 class="highLightText">Get a formal ADHD diagnosis to understand your concerns
                                                        better.</h5>
                                                </div>
                                                <div class="highLight">
                                                    >Access prescriptions with medications that will help you get
                                                        better.</h5>
                                                </div>
                                            </div> -->





                        </div>
                    </div>
                </div>
            </div>
    </div>





@endsection
