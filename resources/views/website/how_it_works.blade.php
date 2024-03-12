@extends('layout.mainlayout', ['active_page' => 'about us'])

@section('title', __('How it Works'))

@section('content')

    <section id="how_it_works" class="steps">
        <div class="workContainer">
            <h2 class="heading">How it works</h2>
            <div class="workContainer-item workContainer-item-1">
                <img class="how-it-works-image" style="height: 300px; object-fit: cover" alt="" src="assets/images/how_it_works_01.jpg">
                <div class="how-it-works-content">
                    <h2> Know your needs and choose a plan</h2>
                    <p>
                        Select a session package based on your requirements.
                    </p>
                </div>
            </div>
            <div class="arrowContainer">
                <img class="lozad" alt=""
                
                    src="assets/images/arrowDown.png">
            </div>
            <div class="workContainer-item workContainer-item-2">
                <div class="how-it-works-content">
                    <h2> Choose a therapist: </h2>
                    <p>
                        Select a therapist that meets your requirements and interests. Choose from a
                        wide pool of licensed therapists with the best qualifications, years of experience,
                        languages & areas of expertise.
                    </p>
                </div>
                <img class="how-it-works-image" alt="" src="assets/images/how_it_works_02.jpg">
            </div>
            <div class="arrowContainer">
                <img alt=""
                    src="assets/images/arrowDown.png">
            </div>
            <div class="workContainer-item workContainer-item-3">
                <img class="how-it-works-image" src="assets/images/how_it_works_03.png" alt="">
                <div class="how-it-works-content">
                    <h2>
                        Therapy at your fingertips:
                    </h2>
                    <p>
                        Schedule an appointment based on your convenience
                        & join your session. Talk to your therapist however you feel comfortable — text,
                        audio or video.
                    </p>
                </div>
            </div>
            <div class="arrowContainer">
                <img alt=""
                    src="assets/images/arrowDown.png">
            </div>
            <div class="workContainer-item workContainer-item-4">
                <div class="how-it-works-content">
                    <h2>
                        Constant support:
                    </h2>
                    <p>
                        Discuss your queries with your therapist over text after your
                        sessions, reschedule sessions, reach out to us for any other help. We are always
                        here for you.
                    </p>
                </div>
                <img class="how-it-works-image" src="assets/images/how_it_works_04.jpg" alt="">
            </div>
        </div>
    </section>

@endsection
