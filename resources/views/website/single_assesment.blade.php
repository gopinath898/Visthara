@extends('layout.mainlayout', ['active_page' => 'blog'])

@section('title', __($blog->title))

@section('css')
    <style>
        .card {
            text-align: center;
        }

        .blog-grid .blog-info .btn-bar {
            margin-top: 20px;
        }

        .px-btn-arrow {
            padding: 0 50px 0 0;
            line-height: 20px;
            position: relative;
            display: inline-block;
            color: #fe4f6c;
            -moz-transition: ease all 0.3s;
            -o-transition: ease all 0.3s;
            -webkit-transition: ease all 0.3s;
            transition: ease all 0.3s;
        }


        .px-btn-arrow .arrow {
            width: 13px;
            height: 2px;
            background: currentColor;
            display: inline-block;
            position: absolute;
            top: 0;
            bottom: 0;
            margin: auto;
            right: 25px;
            -moz-transition: ease right 0.3s;
            -o-transition: ease right 0.3s;
            -webkit-transition: ease right 0.3s;
            transition: ease right 0.3s;
        }

        .px-btn-arrow .arrow:after {
            width: 8px;
            height: 8px;
            border-right: 2px solid currentColor;
            border-top: 2px solid currentColor;
            content: "";
            position: absolute;
            top: -3px;
            right: 0;
            display: inline-block;
            -moz-transform: rotate(45deg);
            -o-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
        }

        .card__img {
            margin-bottom: 5px;
        }

        .card__title {
            text-transform: capitalize;
            color: var(--site_color);
            line-height: 20px;
            font-size: 20px;
            margin-top: 10px;
        }

        .card__text {
            color: var(--grey);
            font-size: 16px;
            line-height: 26px;
            margin-bottom: 20px;
        }

        .card__readbtn {
            font-size: 14px;
            text-transform: uppercase;
            color: var(--site_color_hover);
            text-decoration: none;
            line-height: 26px;
            transition: all ease 0.3s;
            position: relative;
        }

        .card__readbtn::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 0;
            height: 2px;
            background-color: var(--site_color);
            transition: all ease 0.3s;
        }

        .card__readbtn:hover {
            color: var(--site_color);
        }

        .card__readbtn:hover::after {
            width: 100%;
        }

        .divider {
            background-color: var(--site_color_hover);
            height: 2px;
            max-width: 30px;
            margin: 15px auto 20px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 35px;
            max-width: 1300px;
            margin: 50px auto;
            padding: 0 10px;
        }

        .card__contenido .content_div {
            margin-left: 5px;
            margin-right: 5px;
        }

        .card__contenido {
            padding: 18px;
        }
    </style>
@endsection

@section('content')
    <div class="full-content" style="background: #fbfbfbcc;">
        <div class="content px-lg-0 px-2 my-4 mx-auto">
            <div class="row">
                <div class="col-md-6"
                    style="display: flex;flex-direction: column;align-items: center;justify-content: center;text-align: center;">
                    <div class="card__img">
                        <img src="{{ url($blog->full_image) }}" style="object-fit: cover;border-radius: 100%;width: 200px"
                            alt="">
                    </div>
                    <div class="introductionContainer">

                        <h5>{{ $blog->name }}
                        </h5>
                        <div class="divider"></div>
                        <p class="card__text">
                            {!! clean($blog->description) !!}
                        </p>


                    </div>
                </div>
                {{-- <div class="col-md-1"></div> --}}
                <div class="col-md-6"
                    style="display: flex;flex-direction: column;align-items: center;justify-content: center;text-align: center;background-color: #02a3a1;border-radius: 20px;box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;color: white;margin: 0;">

                    </p>
                    <h5 style="padding: 1rem; margin: 1rem; font-weight: bolder;color: white;font-size: 1.5rem">Instructions
                    </h5>
                    <p
                        style="padding: 0px; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-family: Montserrat, sans-serif; line-height: 1.8;color: white;">
                        Choose the response that best describes how you think,<br /> feel, or behave in the past 2 weeks.
                    </p>
                    <ul style="padding: 0px 0px 0px 0px; margin-right: 0px; margin-left: 0px; list-style-type: none;">
                        <li style="padding: 0px; margin: 0px;">There are no right or wrong answers</li>
                        <li style="padding: 0px; margin: 0px;">Total no of questions: 15</li>
                        <li style="padding: 0px; margin: 0px;">Estimated time required: 5 minutes</li>
                    </ul>

                    {{-- <div class="divider"></div> --}}


                    <div class="btn-bar" style="margin: 10px">
                        <a href="{{ url('assesmentsingle/' . $blog->id . '/' . Str::slug($blog->name)) }}"
                            class="btn default-btn">
                            <span>Start Assessment</span>
                            <!-- <i class="arrow"></i> -->
                        </a>
                    </div>



                </div>
            </div>
        </div>

    </div>
@endsection
