@extends('layout.mainlayout', ['active_page' => 'about us'])

@section('title', __('About Us'))

@section('content')


    {{-- <div class="container"> --}}

    {{-- <section class="contact-info-area pt-100 pb-70">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="contact-info-box">
                            <div class="icon">
                                <i class='flaticon-phone-call'></i>
                                <h3>Phone Number</h3>
                            </div>

                            <p><i class="flaticon-check"></i> <a href="tel:+919103957710">+919103957710</a></p>

                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="contact-info-box">
                            <div class="icon">
                                <i class='flaticon-mail'></i>
                                <h3>Email Address</h3>
                            </div>

                            <a href="mailto:support@myminddoctor.com">support@myminddoctor.com</a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="contact-info-box">
                            <div class="icon">
                                <i class='flaticon-placeholder'></i>
                                <h3>Address</h3>
                            </div>

                            <p><i class="flaticon-check"></i> My mind Doctor opposite Polytechnic college Gogji Bagh
                                Srinagar Kashmir</p>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}
    <!-- End Contact Info Area -->

    <!-- Start Contact Area -->
    {{-- <section class="contact-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="contact-form">
                            <h3>Get In <span>Touch</span></h3>
                            <form id="contactForm">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="name" id="name" class="form-control" required
                                        data-error="Please enter your name" placeholder="Name">
                                    <div class="help-block with-errors name"></div>
                                </div>

                                <div class="form-group">
                                    <input type="email" name="email" id="email" class="form-control" required
                                        data-error="Please enter your email" placeholder="Email">
                                    <div class="help-block with-errors email"></div>
                                </div>

                                <div class="form-group">
                                    <input type="number" name="phone" id="phone" required
                                        data-error="Please enter your number" class="form-control" placeholder="Phone">
                                    <div class="help-block with-errors phone"></div>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="subject" id="subject" class="form-control" required
                                        data-error="Please enter your subject" placeholder="Subject">
                                    <div class="help-block with-errors subject"></div>
                                </div>

                                <div class="form-group">
                                    <textarea name="message" class="form-control" id="message" cols="30" rows="5" required
                                        data-error="Write your message" placeholder="Your Message"></textarea>
                                    <div class="help-block with-errors message"></div>
                                </div>

                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="termsChecked" id="accept"
                                        required>
                                    <label class="form-check-label" for="accept">I Accept All <a
                                            href="terms-of-service.html">Terms & Condition</a></label>
                                    <div class="help-block with-errors termsChecked"></div>
                                </div>

                                <button type="submit" class="default-btn">Send Message <i
                                        class="flaticon-pointer"></i></button>
                                <div id="msgSubmit" class="h3 text-center hidden"></div>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="contact-image"></div>
                    </div>
                </div>
            </div>
        </section> --}}







    <div class="formContainer">
        <div class="contactBanner">
            <div class="bannerContent">
                <h1 color="#FFFFFF">Contact Us</h1><br>
                <h4 color="#FFFFFF">Do you have any concerns or questions you would like to address? Our client care
                    team is happy to help you.
                </h4>
            </div>
            <img src="assets/images/contactBanner.avif" style="border-radius: 50% 80% 25% 60%" draggable="false">
        </div>
        <div class="detailsContainer">
            <p class="">Have a question? <span>Talk to us.</span></p>
            <div class="cardContainer">
                <div class="containerItem container-item-1">
                    <div class="imageContainer">
                        <img height="80" width="80"src="assets/images/contactEmail.png" draggable="false">
                    </div>
                    <div class="contactContent">
                        <span color="#E76943" class="">Email us at</span>
                        <div class="contentContainerItem">
                            <h5 color="#4C4C4C" class="">support@myminddoctor.com</h5>
                            <h5>and we'll get back to you in 24 hours</h5>
                        </div>
                    </div>
                </div>
                <div class="containerItem container-item-2">
                    <div class="imageContainer">
                        <img height="80" width="80" src="assets/images/contactLocation.avif" draggable="false">
                    </div>
                    <div class="contactContent">
                        <span color="#E76943">Visit Us at</span>
                        <div class="contentContainerItem">
                            <h5 color="#4C4C4C">
                                My mind Doctor opposite Polytechnic college Gogji Bagh
                                Srinagar Kashmir
                            </h5>
                        </div>
                    </div>
                </div>

                <div class="containerItem container-item-3">
                    <div class="imageContainer">
                        <img height="80" width="80" src="assets/images/contactPhone.png" draggable="false">

                    </div>
                    <div class="contactContent">
                        <span color="#E76943">Call us at</span>
                        <div class="contentContainerItem">
                            <h5 color="#4C4C4C" ">+91 91039 57710</h5>
                                        <h5>Between 10 AM to 10 PM</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="contactFormContainer">
                        <div class="description">
                            <h2 color="#4C4C4C" class="">We'd love
                                to hear from you!</h2>
                            <h4 color="#4C4C4C" class="">Drop us a
                                message by filling this form and we'll get back to you.</h4>
                        </div>
                        <form id="contactForm" method="POST" action="{{ route('submit-query') }}">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="name" id="name" class="form-control" required
                                    data-error="Please enter your name" placeholder="Name">
                                <div class="help-block with-errors name"></div>
                            </div>
            
                            <div class="form-group">
                                <input type="email" name="email" id="email" class="form-control" required
                                    data-error="Please enter your email" placeholder="Email">
                                <div class="help-block with-errors email"></div>
                            </div>
            
                            <div class="form-group">
                                <input type="number" name="phone" id="phone" required
                                    data-error="Please enter your number" class="form-control"
                                    placeholder="Phone">
                                <div class="help-block with-errors phone"></div>
                            </div>
            
                            {{-- <div class="form-group">
                        <input type="text" name="subject" id="subject" class="form-control" required
                            data-error="Please enter your subject" placeholder="Subject">
                        <div class="help-block with-errors subject"></div>
                    </div> --}}
            
                            <div class="form-group">
                                <textarea name="message" class="form-control" id="message" cols="30" rows="5" required
                                    data-error="Write your message" placeholder="Your Message"></textarea>
                                <div class="help-block with-errors message"></div>
                            </div>
            
                            {{-- <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="termsChecked" id="accept"
                            required>
                        <label class="form-check-label" for="accept">I Accept All <a
                                href="terms-of-service.html">Terms &
                                Condition</a></label>
                        <div class="help-block with-errors termsChecked"></div>
                    </div> --}}
            
                            <button type="submit" class="default-btn">Send Message</button>
                            <div id="msgSubmit" class="h3 text-center hidden"></div>
                            <div class="clearfix"></div>
                        </form>
                    </div>


            {{-- </div> --}}
@endsection
