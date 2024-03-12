<footer class="footer-area mt-2 mb-2">
    <div class="full-content">
        <div class="footer-heading">
            <p class="text-white">If you didn't find what you are looking for, please reach out to us at <a href="mailto: {{ $setting->email}}">{{ $setting->email }}</a> or <a href="tel:{{ $setting->phone }}">{{ $setting->phone }}</a>. We'll be happy to help.</p>
        </div> 
        <div class="footer-main footer-border">
            <ul class="d-flex footer-links">
                <li><a href="{{url('/')}}">Home</a></li>
                <li><a href="{{url('/user_about_us')}}">About Us</a></li>
                <li><a href="{{url('/faq')}}">FAQ</a></li>
                <li><a href="{{url('/contact')}}"> Get in Touch</a></li>
                <li><a href="{{url('/therapy/therapy_login')}}">Therapist Login</a></li>
            </ul>
        </div>
        <div class="footer-main pb-50">
            <ul class="d-flex footer-links">
                <li><a href="{{url('/terms-and-conditions')}}">Terms and Conditions</a></li>
                <li><a href="{{url('/privacy-policy')}}">Privacy Policy</a></li>
                <li><a href="{{url('/cookies-policy')}}">Cookies Policy</a></li>
                <li><a href="{{url('/policy-terms')}}">Terms of Use</a></li>
            </ul>
        </div>
        <div class="row" style="text-align: center;display: inline-block;width: 100%;">
                        <div class="logo" style="width: 180px;text-align: center;display: inline-block;">
                            <a href="{{url('/')}}">
                                <img src="{{ url('images/upload/'.$setting->company_logo)}}" class="black-logo" alt="image">
                                <img src="{{ url('images/upload/'.$setting->company_logo)}}" class="white-logo" alt="image">
                            </a>
                        </div>
                    </div>

        <div class="text-center footer-bottom">
            <p>Medical or psychological emergencies are not handled by MMD. Medical care provided on-site is the most effective type of assistance in these circumstances.<br>
            If you believe you are having suicidal or self-harm thoughts, or are exhibiting symptoms of a serious clinical condition, we advise you to get help at the nearest hospital where you can speak with a psychiatrist, counselor, or therapist in person. We also propose that you seek help of a family member or a friend</p>
            <p>You can also reach out to a suicide hotline in your country of residence: <a href="http://www.healthcollective.in/contact/helplines" target="_blank">http://www.healthcollective.in/contact/helplines</a></p>
        </div>
    </div>
</footer>

<script type="text/javascript">
    function viewConvs(url, id_to_active) {
            current_selected_user = id_to_active;     //for reloading conversation body

            //inactive selected user from sidebar
            var counter_element = $('#counter-'+ current_selected_user.slice(9));
            var customer_element = $('#'+current_selected_user);
            if(counter_element !== "undefined") {
                counter_element.empty();
                counter_element.removeClass("badge");
                counter_element.removeClass("badge-info");
            }
            if(customer_element !== "undefined") {
                customer_element.removeClass("conv-active");
            }


            $('.customer-list').removeClass('conv-active');
            $('#' + id_to_active).addClass('conv-active');
            $.get({
                url: url,
                success: function (data) {
                    $('#view-conversation').html(data.view);
                }
            });
        }

        function replyConvs(url) {
            var form = document.querySelector('form');
            var formdata = new FormData(form);
            msg = $('#replyid').val()


            if (!msg) {
                alert('Reply message is required!', {
                    CloseButton: true,
                    ProgressBar: true
                });
                return "false";
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                type: 'POST',
                dataType: "json",
                contentType: "application/json; charset=utf-8",
                data: JSON.stringify({ 'reply':msg}),
                success: function (data) {
                    // toastr.success('Message sent', {
                    //     CloseButton: true,
                    //     ProgressBar: true
                    // });
                    $('#view-conversation').html(data.view);
                },
                error() {
                    alert('Please Reload page', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        }

        function renderUserList() {
            $('#loading').show();
            $.ajax({
                url: "{{route('get_conversations')}}",
                type: 'GET',
                cache: false,
                success: function (response) {
                    $('#loading').hide();
                    $("#conversation_sidebar").html(response.conversation_sidebar)

                },
                error: function (err) {
                    $('#loading').hide();
                }
            });
        }

</script>
<script>
    var url = 'https://wati-integration-service.clare.ai/ShopifyWidget/shopifyWidget.js?95086';
    var s = document.createElement('script');
    s.type = 'text/javascript';
    s.async = true;
    s.src = url;
    var options = {
  "enabled":true,
  "chatButtonSetting":{


      "backgroundColor":"#4dc247",
      "ctaText":"Message Us",
      "borderRadius":"25",
      "marginLeft":"0",
      "marginBottom":"50",
      "marginRight":"50",
      "position":"right"
  },
  "brandSetting":{
      "brandName":"My Mind Doctor",
      "brandSubTitle":"",
      "brandImg":"/images/favi.JPG",
      "welcomeText":"Hi there!\nHow can I help you?",
      "messageText":"Hello, I have a question about "+window.location.href,
      "backgroundColor":"#0a5f54",
      "ctaText":"Start Chat",
      "borderRadius":"25",
      "autoShow":false,
      "phoneNumber":"919103957710"
  }
};
    s.onload = function() {
        CreateWhatsappChatWidget(options);
    };
    var x = document.getElementsByTagName('script')[0];
    x.parentNode.insertBefore(s, x);


</script>