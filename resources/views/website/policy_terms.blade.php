@extends('layout.mainlayout',['active_page' => 'about us'])

@section('title',__('Terms And Conditions'))

@section('content')
<div class="full-content mb-5">
    <div class="container mt-5">
        <div class="mb-4">
            <h4>Terms and Conditions of Use</h4>
            <p>The following Terms and Conditions govern your use of this website. By using our website, you agree to be bound by these terms and conditions. If you do not agree to these terms and conditions, please do not use our website.</p>
        </div>
        <div class="mb-3">
            <h5>Use of the Website</h5>
            <p>Our website is intended for use by individuals seeking online therapy/counselling services (referred to interchangeably as “teletherapy” services).</p>
            <p>By using our website, you agree to provide accurate and complete information about yourself in order for us and our therapists to provide you with the best possible services.</p>
            <p>Users under the age of 18 are not permitted to sign up for teletherapy services on their own. Teletherapy services sought for the benefit of minors will have to be solicited by their parent(s)/guardian(s). In other words, the therapy contract for a minor will be signed by his/her parent(s)/guardian(s).</p>
        </div>
        <div class="mb-3">
            <h5>Teletherapy Services</h5>
            <p>Our website provides access to teletherapy services, which are provided by duly qualified therapists/clinical psychologists/counsellors.</p>
        </div>
        <div class="mb-3">
            <h5>Disclaimer</h5>
            <p>We do not provide medical advice, diagnosis, or treatment. We do not provide psychiatric services/care. Our teletherapy services are not a substitute for in-person mental health treatment. The counselling provided by counsellors/therapists through this website is for informational purposes only.  It is your responsibility to take decisions fit for your situation and not rely solely on the advice given/views expressed by the counsellor/therapist.</p>
            <p><u>Note: </u>My Mind Doctor’s role as a website and platform is limited to providing you with access to a counsellor/therapist. We hereby disclaim any liability that may arise from the teletherapy sessions you undertake with the counsellors/therapists through this website.</p>
        </div>
        <div class="mb-3">
            <h5>Privacy</h5>
            <p>We are committed to protecting your privacy. Our Privacy Policy outlines how we collect, use, and protect the information that you provide to us through our website. Please read our Privacy Policy prior to using this website.</p>
        </div>
        <div class="mb-3">
            <h5>Intellectual Property</h5>
            <p>All content on our website, including text, graphics, logos, and images, is the property of our owners/licensors and is protected by intellectual property laws. You may not copy, reproduce, distribute, or display any content from our website without our prior written consent.</p>
        </div>
        <div class="mb-3">
            <h5>Disclaimer of Warranties</h5>
            <p>All information available on this website is provided on an “as is” basis. We make no warranties, expressed or implied, and disclaim all other warranties including implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights.</p>
            <p>We do not warrant that our website will be uninterrupted or error-free. We make no warranties, express or implied, regarding the accuracy, completeness, or reliability of the information provided on our website. </p>
        </div>
        <div class="mb-3">
            <h5>Limitation of Liability</h5>
            <p>In no event shall we be liable for any damages, including without limitation, direct, indirect, incidental, special, consequential, or punitive damages, arising out of or in connection with your use of our website or our teletherapy services.</p>
        </div>
        <div class="mb-3">
            <h5>Indemnification</h5>
            <p>You agree to indemnify and hold us harmless from any claims, damages, losses, liabilities, or expenses arising out of or in connection with your use of our website or our teletherapy services.</p>
        </div>
        <div class="mb-3">
            <h5>Governing Law</h5>
            <p>These terms and conditions shall be governed by and construed in accordance with the laws of the Republic of India.</p>
        </div>
        <div class="mb-3">
            <h5>Dispute Resolution</h5>
            <p>Any disputes arising out of or relating to the use of this website or its services shall be settled by arbitration in accordance with the provisions of the Arbitration & Conciliation Act, 1996.</p>
            <p>The arbitral tribunal shall consist of a sole arbitrator to be mutually agreed by the parties to whom the disputes shall be referred.</p>
            <p>In case a sole arbitrator cannot be mutually appointed, either party to the dispute may initiate proceedings in the appropriate court pursuant to the Arbitration & Conciliation Act, 1996 for appointment of an arbitrator.</p>
            <p>The seat and venue of such arbitration shall be New Delhi. The courts at New Delhi shall have exclusive jurisdiction to entertain any litigation ancillary to the above dispute resolution mechanism.</p>
        </div>
        <div class="mb-3">
            <h5>Changes to these Terms and Conditions</h5>
            <p>We may update these Terms and Conditions from time to time without any prior notice. Any amendments will be posted on our website, and will be effective immediately upon posting. As a user of the website, it is your responsibility to regularly check this page and other policies to keep up to date.</p>
        </div>
        <div class="mb-3">
            <h5></h5>
            <p></p>
        </div>
        <div class="mb-3">
            <h5></h5>
            <p></p>
        </div>
        <div class="mb-3">
            <h5></h5>
            <p></p>
        </div>
        <div class="mb-3">
            <h5></h5>
            <p></p>
        </div>
        <div class="mb-3">
            <h5></h5>
            <p></p>
        </div>
        <div class="mb-3">
            <h5>Contact Us</h5>
            <p>If you have any questions or concerns about these terms and conditions, please write to us at <a href="mailto: {{ $email }}">{{ $email }}</a></p>
        </div>
    </div>
</div>
@endsection