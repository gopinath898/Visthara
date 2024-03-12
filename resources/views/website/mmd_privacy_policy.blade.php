@extends('layout.mainlayout',['active_page' => 'about us'])

@section('title',__('Terms And Conditions'))

@section('content')
<div class="full-content mb-5">
    <div class="container mt-5">
        <div class="mb-4">
            <h4><u>Privacy Policy</u></h4>
            <p>This Privacy Policy outlines how we collect, use, and protect the information that you provide us through our website. We are committed to protecting your privacy and ensuring that your personal information is handled in a safe and responsible manner.</p>
        </div>
        <div class="mb-3">
            <h5>Information We Collect </h5>
            <p>We collect personal information that you voluntarily provide to us when you use our website and eventually sign up for our services. This may include your name, email address, phone number and some brief information about the difficulties for which you are seeking support. We may also collect information about your use of our website, such as your IP address and browsing behaviour.</p>
            <p>It may be noted that any information exchanged during a therapy/counselling session will be stored securely by the therapist/counsellor himself/herself and not by the website or its owner. The website and its owners will not be privy to such information. This information is treated as strictly confidential and shall not be disclosed to any third party unless it falls within the domain of one the recognised exceptions, which will be communicated to you at the time of signing up.</p>
        </div>
        <div class="mb-3">
            <h5>Use of Information</h5>
            <p>We use the information you provide us to facilitate your teletherapy sessions, to communicate with you, and to improve our services. We may also use your information to comply with legal and regulatory requirements, to enforce our policies, and to protect our rights and the rights of others.</p>
        </div>
        <div class="mb-3">
            <h5>Accuracy of Information</h5>
            <p>We make every effort to ensure that your personal information is accurate, complete and up to date. In case of any change in your information such as your email address or phone number, we request you to inform us of the same at the earliest to allow us to update our records.</p>
        </div>
        <div class="mb-3">
            <h5>Disclosure of Information</h5>
            <p>We may disclose your personal information to our contractors, and service providers who need to access the information to provide you with teletherapy services. We may also disclose your information to law enforcement agencies, government regulators, or other third parties where required by law.</p>
        </div>
        <div class="mb-3">
            <h5>Security</h5>
            <p>We take reasonable precautions to protect your personal information from unauthorised access, use, or disclosure. We use a variety of physical, technical, and administrative measures to safeguard your information, including encryption and firewalls.</p>
        </div>
        <div class="mb-3">
            <h5>Cookies</h5>
            <p>We may use cookies to enhance your user experience and to collect information about your use of our website. Cookies are small files that are stored on your device when you visit a website. You can adjust your browser settings to refuse cookies or to alert you when cookies are being sent. For further information, please refer to our Cookies Policy.</p>
        </div>
        <div class="mb-3">
            <h5>Links to Other Websites</h5>
            <p>Our website may contain links to other websites including video conferencing platforms and payment gateways that are not under our control. We are not responsible for the privacy practices or content of these websites. We encourage you to review the privacy policies of these websites before providing any personal information.</p>
        </div>
        <div class="mb-3">
            <h5>Changes to This Policy</h5>
            <p>We may update this Privacy Policy from time to time without any prior notice. Any amendments made to this policy will be posted on our website, and will be effective immediately upon posting.  As a user of the website, it is your responsibility to regularly check this and other policies to keep up to date.</p>
        </div>
        <div class="mb-3">
            <h5>Contact Us</h5>
            <p>If you have any questions or concerns about this Privacy Policy, please write to us at <a href="mailto: {{ $email }}">{{ $email }}</a></p>
        </div>
    </div>
</div>
@endsection