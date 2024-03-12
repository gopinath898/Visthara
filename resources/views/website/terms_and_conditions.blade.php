@extends('layout.mainlayout',['active_page' => 'about us'])

@section('title',__('Terms And Conditions'))

@section('css')
<style>
    ul {
        list-style-type: decimal;
    }
</style>
@endsection
@section('content')
<div class="full-content mb-5">
    <div class="container mt-5">
        <div>
            <h4 class="text-center">The Therapy Contract</h4>
            <p class="mt-3 ml-5">
            <b><u>Please read the below Terms and Conditions carefully before proceeding.</u></b>
            <br>
            Once you have ticked the box at the bottom and clicked ‘Agree’, you will be bound by the Terms and Conditions contained hereunder.
            </p>
        </div>
        <div class="mt-4">
            <h4 class="text-center">Terms & Conditions</h4>
            <div>
                <h6 class="mt-2">Nature of the Sessions</h6>
                <ul>
                    <li>Therapists contracted by My Mind Doctor (“the Platform”) will provide therapy/counselling to you, the Client. </li>
                    <li>One session will last for up to 50 minutes.</li>
                    <li>The sessions will take place weekly or further apart – depending on your requirements.</li>
                    <li>You may choose your own Therapist by going through the website and informing us of your choice. Alternatively, if you so wish, we can connect you with an appropriate Therapist.</li>
                    <li>Sessions will be conducted through videoconferencing via zoom</li>
                    <li>Information on how to join will be provided to you prior to the first session.</li>
                    <li>It is your responsibility to ensure that you are ready to connect at the agreed time for the session.</li>
                    <li>We ask that you do not attend therapy sessions under the influence of alcohol or drugs and ask that you dress appropriately for the sessions.</li>
                    <li>Total privacy will be provided from the Therapist’s end and the session will require you to have privacy for yourself in a quiet room.</li> 
                </ul>
            </div>
            <div>
                <h6>Payment</h6>
                <ul>
                    <li>Payment of fees for the sessions must be made prior to the session. Without the payment of fees, the session will not be confirmed.</li>
                    <li>Payments can only be made electronically through the Platform’s payment service provider – Instamojo.</li>
                </ul>
            </div>
            <div>
                <h6>Cancellation Policy</h6>
                <ul>
                    <li>In case you are unable to attend a session or for any reason wish to cancel a session, you must inform either your Therapist or a representative of the Platform at the earliest.</li>
                    <li>If you cancel a session with a notice of 24 hours or more, you will not be charged for that session. However, if you cancel a session.</li>
                    <li>We will, however, be willing to show discretion in some instances when your missing the scheduled appointment cannot be helped. In such instances we can arrange an alternative time for your session.</li>
                </ul>
            </div>
            <div>
                <h6>Arriving Late to the Session or Missing the Session</h6>
                <ul>
                    <li>Sessions are organised for an agreed date and time slot. We ask that you abide by the schedule as far as practicable.</li>
                    <li>In the event that you are late to the session, the Therapist will stay online for 20 minutes to allow for any eventualities. If you do not make contact within this time, the session will be considered missed and will be cancelled. You will be charged the regular fee for this session.</li>
                    <li>In the event that you are late to the session but do arrive within the 20 minute period mentioned above, the session will still end at the original end time for the session. In other word, the time for the session will not be extended.</li>
                </ul>
            </div>
            <div>
                <h6>Technical Difficulties</h6>
                <ul>
                    <li>In the event that either you or the Therapist is late for a session due to technical problems, the Therapist will do his/her best to accommodate you within reason, while being mindful of the next client who needs their session at the designated time.</li>
                    <li>In the event that the technical problems encountered are of such a nature that it becomes impossible to conduct the session at the original time the session will be postponed for a different time.</li>
                </ul>
            </div>
            <div>
                <h6>Confidentiality</h6>
                <ul>
                    <li>Your privacy and confidentiality is paramount to us. Everything discussed during your session with the Therapist and any notes that the Therapist may take during and after the session will be treated as highly confidential.</li>
                    <li>In accordance with our rules, all your records, including therapy notes, will be stored securely by the Therapist for a period of 7 years from the date of the last therapy session taken.</li>
                    <li>The Platform will only be storing basic information about you such as your name, email address, phone number and date of birth. The Platform will not be privy to any confidential information relating to your session with the Therapist.</li>
                    <li>Confidentiality may, however, need to the broken in certain limited instances. The need for breaking confidentiality focuses on keeping you as the Client and others safe from harm.</li>
                    <li>
                        The only circumstances in which confidentiality can be broken are: 
                        <ul style="list-style-type: lower-roman">
                            <li>When you give consent to the Therapist to do so;</li>
                            <li>When the Therapist is of the opinion that you are likely to cause serious harm/be of danger to yourself or to any one around you;</li>
                            <li>When the Therapist is legally compelled by a court of law or otherwise through the operation of law to break confidentially;</li>
                            <li>For the purpose of supervision.</li>
                        </ul>
                    </li>
                    <li>For the purpose of Clause 24 (ii) if the need arises, the Therapist has a duty of care to raise that concern with appropriate professionals or family members in order to support you further. <u>The Therapist will always explore this with you first.</u></li>
                    <li>For the purpose of Clause 24 (iv) supervision is the process of reviewing the work your Therapist does with another Therapist/Supervisor. This is to ensure that your Therapist is always working in your best interest. During such supervisory sessions, the Therapist is only permitted to discuss their therapy work with a Supervisor in such a manner that does not reveal your identity to them.</li>
                </ul>
            </div>
            <div>
                <h6>Dual Relationship</h6>
                <ul>
                    <li>The Therapist shall aim to develop a trusting and friendly working relationship with you, however, as a therapist he/she is not a “friend”. To maintain the confidentiality and the boundaries of the work, it is not appropriate for you and the Therapist to engage “socially” on any social network and/or social or professional forums or contact each other in any way outside of the Platform. By signing this Contract you agree to not contact the Therapist in any way or manner whether virtually or otherwise outside of the Platform.</li>
                </ul>
            </div>
            <div>
                <h6>Reviews</h6>
                <ul>
                    <li>For the purpose of monitoring and quality assessment, we request you to offer your reviews and rating of the Therapists that you engage with. This helps us, as a Platform, to ensure that we provide the best possible counselling and therapy to our clients – both present and future.</li>
                </ul>
            </div>
            <div>
                <h6>Ending Therapy</h6>
                <ul>
                    <li>Generally the ending of a therapy contract would be by mutual prior agreement and will draw to a natural close as the sessions go on. However, you have the right to end your therapy sessions at any time. You must notify both your Therapist and a representative of the Platform of your desire to conclude your work with us.</li>
                </ul>
            </div>
            <div>
                <h6>General Terms and Conditions on the Website</h6>
                <ul>
                    <li>It is your responsibility to regularly read and understand the General Terms and Conditions published on the Platform’s website which are hereby incorporated by reference.</li>
                </ul>
            </div>
        </div>    
    </div>
</div>
@endsection