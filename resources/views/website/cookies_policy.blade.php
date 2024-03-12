@extends('layout.mainlayout',['active_page' => 'about us'])

@section('title',__('Terms And Conditions'))

@section('css')
<style>
    ul {
        list-style-type: disc;
    }
</style>
@endsection

@section('content')
<div class="full-content mb-5">
    <div class="container mt-5">
        <div class="mb-4">
            <h4><u>Cookies Policy</u></h4>
            <p>This cookies policy explains how our website uses cookies to improve your browsing experience. By using our website, you consent to our use of cookies in accordance with this policy.</p>
        </div>
        <div class="mb-3">
            <h5>What Are Cookies?</h5>
            <p>Cookies are small text files that are placed on your computer or mobile device when you visit a website. They allow the website to recognise your device and remember your preferences or actions over time.</p>
        </div>
        <div class="mb-3">
            <h5>Types of Cookies</h5>
            <p><u>Strictly necessary cookies: </u>These cookies are essential for the operation of our website and cannot be disabled in our systems.</p>
            <p><u>Functional cookies: </u>These cookies allow our website to remember your preferences or actions and provide enhanced, more personalised features.</p>
            <p><u>Performance cookies: </u>These cookies collect information about how you use our website, such as which pages you visit most often. This information helps us improve the performance and usability of our website.</p>
            <p><u>Analytics cookies: </u>These cookies collect information about your use of our website and enable us to analyse your behaviour and improve our website.</p>
        </div>
        <div class="mb-3">
            <h5>How we use Cookies</h5>
            <p>We use cookies to improve your browsing experience and personalise your interactions with our website. We also use cookies to collect and log analytical information, to help analyse use, to compile statistical reports on use of our website and to improve our website and marketing.</p>
            <p>In particular, the following data may be collected:</p>
            <ul>
                <li>Number of visitors to our website;</li>
                <li>Pages visited while at the website and time spent per page;</li>
                <li>Page interaction information, such as scrolling, clicks and browsing methods;
                <li>Websites from where visitors have come and where they go afterwards;</li>
                <li>Page response times and any download errors; and</li>
                <li>Other technical information relating to end user device, such as IP address or browser plug-in.</li>
            </ul>
        </div>
        <div class="mb-3">
            <h5>Managing Cookies</h5>
            <p>You can control the use of cookies on our website by adjusting your browser settings. However, please note that disabling cookies may affect your ability to use some features of our website.</p>
        </div>
        <div class="mb-3">
            <h5>Third-Party Cookies</h5>
            <p>We use third-party cookies on our website, such as Google Analytics, to analyse your behaviour and improve our website. These cookies are subject to the privacy policies of their respective owners.</p>
        </div>
        <div class="mb-3">
            <h5>Changes To This Cookies Policy</h5>
            <p>We may update this Cookies Policy from time to time without any prior notice. Any amendments will be posted on our website, and will be effective immediately upon posting. As a user of the website, it is your responsibility to regularly check this and other policies to keep up to date.</p>
        </div>
        <div class="mb-3">
            <h5>Contact Us</h5>
            <p>If you have any questions or concerns about our use of cookies, please write to us at <a href="mailto: {{ $email }}">{{ $email }}</a></p>
        </div>
    </div>
</div>
@endsection