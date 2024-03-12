"use strict";

const progress = document.getElementById("progress");
const prev = document.getElementById("prev");
const next = document.getElementById("next");
const circles = document.querySelectorAll(".circle");

var lat , lng ,currency , amount;
var base_url = $('input[name=base_url]').val();
var $form,inputSelector,$inputs,$errorMessage,valid;
lat = parseFloat($('#lat').val());
lng = parseFloat($('#lng').val());


function selectpackage(div, id,price,name,finalAmount,discountPrice){

        $('.single-pricing-table, .single-session').removeClass('newclicked');
        $('#pack'+id).addClass('newclicked');
        $('#packageselected').val(id);
        $('#packagefee').text(price);
        $('#instamojoprice').val(finalAmount);
        $('.finalAmount').text(finalAmount);
        $('.pricing-button').text('Select');
        $('.discountAmount').text(discountPrice);
        if(discountPrice == 0){
            $('.discountLi').removeClass('d-flex');
            $('.discountLi').hide();
        }else{
            $('.discountLi').addClass('d-flex');
            $('.discountLi').show();
        }
        $(div).text('Selected');
    }


$(document).ready(function () {

    // display timeslot
    $('#date').on('change blur', function () {
        $.ajax({
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data:{
                date:this.value,
                doctor_id:$('input[name=doctor_id]').val(),
            },
            url: base_url + '/displayTimeslot',
            success: function (result)
            {
                $('.timeSlotRow').html('');
                if (result.data.length > 0)
                {
                    $.each(result.data, function (key, value) {
                        var select;
                        if(key == 0)
                        {
                            var select = 'active';
                            $('.timeSlotRow').append('<input type="hidden" name="time" value="'+value.start_time+'">');
                        }
                        else
                          var select = '';
                        $('.timeSlotRow').append(
                          `<div class="m-1 d-flex time ${select} timing${key} rounded-3" onclick="thisTime(${key}, '${value.start_time}')">`+
                            `<a class="selectedClass${key}" href="javascript:void(0)">${value.start_time}-${value.end_time}</a>`+
                          `</div>`);
                    });
                }
                else
                {
                    $('.timeSlotRow').html('<strong class="text-danger w-100">At this time therapist is not available please change the date...</strong>');
                }
            },
            error: function (err) {

            }
        });
    });

     // Check Offer
    $("input[name=offer_code]").focusout(function () {
        $.ajax(
        {
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data:{
                offer_code:this.value,
                date: $('input[name="date"]').val(),
                amount :$('.appointmentFees').text(),
            },
            url: base_url + '/checkCoupen',
            success: function (result)
            {
                if (result.success == true)
                {
                    $('input[name=discount_price]').val(result.data.price);
                    $('input[name=discount_id]').val(result.data.discount_id);
                    $('input[name=amount]').val(result.data.finalAmount);
                    $('.discountLi').removeClass('d-none');
                    $('.discountAmount').text(result.data.price);
                    // $('.finalAmount').text(result.data.finalAmount);
                    Swal.fire({
                        icon: 'success',
                        text: 'you Get ' + result.currency + parseInt(result.data.price) + ' Discount',
                    });
                }
                else
                {
                    $('input[name=discount_price]').val('');
                    $('input[name=discount_id]').val('');
                    $('input[name=amount]').val($('.appointmentFees').text());
                    $('.discountLi').hide();
                    $('.discountAmount').text('');
                    // $('.finalAmount').text($('.appointmentFees').text());
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: result.data,
                    });
                }
            },
            error: function (err) {

            }
        });
    });

    currency = $('input[name=currency]').val();
    amount = $('input[name=amount]').val();
    $('input[name=payment]').change(function ()
    {
        if(this.value == 'paypal')
        {
            $('.paypal_row').show();
            $('.razor_row').hide();
            $('.stripe_row').hide();
            $('.cod_card').hide();
            $('.paystack_row').hide();
            $('.flutterwave_row').hide();
            paypalPayment();
        }
        if(this.value == 'razor')
        {
            $('.paypal_row').hide();
            $('.razor_row').show();
            $('.stripe_row').hide();
            $('.cod_card').hide();
            $('.paystack_row').hide();
            $('.flutterwave_row').hide();
            RazorPayPayment();
        }
        if(this.value == 'cod')
        {
            $('.paypal_row').hide();
            $('.razor_row').hide();
            $('.stripe_row').hide();
            $('.paystack_row').hide();
            $('.flutterwave_row').hide();
        }
        if(this.value == 'stripe')
        {
            $('.paypal_row').hide();
            $('.razor_row').hide();
            $('.stripe_row').show();
            $('.cod_card').hide();
            $('.paystack_row').hide();
            $('.flutterwave_row').hide();
            StripPayment();
        }
        if(this.value == 'paystack')
        {
            $('.paypal_row').hide();
            $('.razor_row').hide();
            $('.stripe_row').hide();
            $('.cod_card').hide();
            $('.paystack_row').show();
            $('.flutterwave_row').hide();
        }
        if(this.value == 'flutterwave')
        {
            $('.paypal_row').hide();
            $('.razor_row').hide();
            $('.stripe_row').hide();
            $('.cod_card').hide();
            $('.paystack_row').hide();
            $('.flutterwave_row').show();
        }
    });
});

let currentActive = 1;
if(next != null){
    next.addEventListener("click", () => {
        currentActive++;
        if (currentActive > circles.length) currentActive = circles.length;
        update();
        shoeStep();
    });

    
    prev.addEventListener("click", () => {
        currentActive--;
        if (currentActive < 1) currentActive = 1;
        update();
        shoeStep();
    });
}


const update = () => {
  circles.forEach((circle, index) => {
    if (index < currentActive) circle.classList.add("progress_active");
    else circle.classList.remove("progress_active");
  });

  const actives = document.querySelectorAll(".progress_active");

  var lenths = 0;

  if(actives.length==2){
    lenths = 2;
  }else if(actives.length==3){
    lenths = 4;
  }else if(actives.length==4){
    lenths = 6;
  }
  progress.style.width =
    lenths * 16.7 + "%";
  if (currentActive === 1) prev.disabled = true;
  else if (currentActive === circles.length) next.disabled = true;
  else {
    prev.disabled = false;
    next.disabled = false;
  }
};

function shoeStep() {
  if ($(circles).filter(".progress_active").length == 1) {
    seeData("#step1");
  }
  if ($(circles).filter(".progress_active").length == 2) {
    seeData("#step2");
  }

  if ($(circles).filter(".progress_active").length == 3) {
    seeData("#step3");
  }

  if ($(circles).filter(".progress_active").length == 4) {
    seeData("#step4");
    $("#payment").addClass("d-block");
    $("#next").addClass("d-none");
    $("#payment").removeClass("d-none");
  } else {
    $("#payment").removeClass("d-block");
    $("#payment").addClass("d-none");
    $("#next").removeClass("d-none");
  }
}

function initAutocomplete()
{
    const map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: lat, lng: lng },
        zoom: 13,
        mapTypeId: "roadmap",
    });

    const a = new google.maps.Marker({
        position: {
            lat: lat,
            lng: lng
        },
        map,
        draggable: true,
    });

    google.maps.event.addListener(a, 'dragend', function() {
        geocodePosition(a.getPosition());
        $('#lat').val(a.getPosition().lat().toFixed(5));
        $('#lng').val(a.getPosition().lng().toFixed(5));
    });
}

function geocodePosition(pos) {
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({
    latLng: pos
    }, function(responses) {
    if (responses && responses.length > 0) {
        $('textarea[name=address]').val(responses[0].formatted_address);
    } else {
        $('textarea[name=address]').val('Cannot determine address at this location.');
    }
    });
}
  
function makePayment()
{
    FlutterwaveCheckout({
      public_key: $('input[name=flutterwave_key]').val(),
      tx_ref: Math.floor(Math.random() * (1000 - 9999 + 1) ) + 9999,
      amount: amount,
      currency: currency,
      payment_options: " ",
      customer: {
        email: $('input[name=email]').val(),
        phone_number: $('input[name=phone]').val(),
        name: $('input[name=name]').val(),
      },
      callback: function (data)
      {
        if (data.status == 'successful')
        {
            $('input[name=payment_status]').val(1);
            $('input[name=payment_token]').val(data.transaction_id);
            $('input[name=payment_type]').val('FLUTTERWAVE');
            booking();
        }
      },
      customizations: {
        title: $('input[name=company_name]').val(),
        description: "Therapist Appointment Booking",
      },
    });
}

function StripPayment()
{
    $form = $(".require-validation");
    $('.btn-submit').bind('click', function (e)
    {
        $form = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]','input[type=text]', 'input[type=file]','textarea'].join(', '),
        $inputs = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid = true;
        $errorMessage.addClass('hide');

        $('.has-error').removeClass('has-error');
        $inputs.each(function (i, el) {
            var $input = $(el);
            if ($input.val() === '')
            {
                $input.parent().addClass('has-error');
                $errorMessage.removeClass('hide');
                e.preventDefault();
            }
        });
        var month = $('.expiry-date').val().split('/')[0];
        var year = $('.expiry-date').val().split('/')[1];
        $('.card-expiry-month').val(month);
        $('.card-expiry-year').val(year);

        if (!$form.data('cc-on-file'))
        {
            e.preventDefault();
            Stripe.setPublishableKey($('input[name=stripe_publish_key]').val());

            Stripe.createToken({
                number: $('.card-number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val()
            }, stripeResponseHandler);
        }
    });

}

function stripeResponseHandler(status, response)
{
    if (response.error) {
        $('.stripe_alert').show();
        $('.stripe_alert').text(response.error.message);
    }
    else
    {
        var token = response['id'];
        $form.find('input[type=text]').empty();
        $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
        var paymentData = new FormData();
        paymentData.append('amount',amount);
        paymentData.append('stripeToken',token);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: base_url + '/stripePayment',
            data: paymentData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (result)
            {
                if (result.success == true)
                {
                    $('input[name=payment_status]').val(1);
                    $('input[name=payment_token]').val(result.data);
                    $('input[name=payment_type]').val('STRIPE');
                    booking();
                }
                else
                {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: "Payment not complete",
                    }
                )}
            },
            error: function (err)
            {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: err.responseJSON.message,
                })
            }
        });
    }
}

function paypalPayment()
{
    if(currency != 'INR')
    {
        $('.paypal_row_body').html('');
        paypal_sdk.Buttons({
            createOrder: function (data, actions)
            {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: amount
                        }
                    }]
                });
            },
            onApprove: function (data, actions)
            {
                return actions.order.capture().then(function (details)
                {
                    $('input[name=payment_type]').val('PAYPAL');
                    $('input[name=payment_status]').val(1);
                    $('input[name=payment_token]').val(details.id);
                    booking();
                });
            }
        }).render('.paypal_row_body');
    }
    else
    {
        $('.paypal_row_body').html('INR currency not supported in Paypal');
    }
}

function RazorPayPayment()
{
    var options =
    {
        key: $('#RAZORPAY_KEY').val(),
        amount: amount * 100,
        description: '',
        currency: currency,
        handler: demoSuccessHandler
    }
    window.r = new Razorpay(options);
    document.getElementById('paybtn').onclick = function ()
    {
        r.open();
    }
}

function padStart(str) {
    return ('0' + str).slice(-2)
}

function demoSuccessHandler(transaction)
{
    $("#paymentDetail").removeAttr('style');
    $('#paymentID').text(transaction.razorpay_payment_id);
    var paymentDate = new Date();
    $('#paymentDate').text(
        padStart(paymentDate.getDate()) + '.' + padStart(paymentDate.getMonth() + 1) + '.' + paymentDate.getFullYear() + ' ' + padStart(paymentDate.getHours()) + ':' + padStart(paymentDate.getMinutes())
    );
    $('input[name=payment_type]').val('RAZOR');
    $('input[name=payment_status]').val(1);
    $('input[name=payment_token]').val(transaction.razorpay_payment_id);
    booking();
}

function payWithPaystack()
{
    var handler = PaystackPop.setup(
    {
        key: $('#paystack-public-key').val(),
        email: document.getElementById('email-address').value,
        amount: amount * 100,
        currency: currency,
        ref: Math.floor(Math.random() * (999999 - 111111)) + 999999,
        callback: function (response)
        {
            $('input[name=payment_type]').val('PAYSTACK');
            $('input[name=payment_status]').val(1);
            $('input[name=payment_token]').val(response.reference);
            booking();
        },
        onClose: function ()
        {
            alert('Transaction was not completed, window closed.');
        },
    });
    handler.openIframe();
}

function booking()
{
    if($('#age').val() < 18 && $('#age').val() != ''){
        if($('input[name=guardian_name]').val() == '' || $('input[name=guardian_phone]').val() == ''){
            if($('input[name=guardian_name]').val() == '' || $('input[name=guardian_phone]').val() == ''){
                $('#prev').trigger('click');
                $('#prev').trigger('click');
                $(".guardian_name").html('Guardian details are required.');
                $(".guardian_phone").html('Guardian details are required.');
            }
            return false;
        }
    }
    var formData = new FormData($('#thisform')[0]);
    var time = formData.getAll('time');
    formData.delete('time');
    formData.append('time',time[0]);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: base_url + '/bookAppointment',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (result)
        {
            
            if (result.success == true)
            {
                // location.replace(base_url+'/user_profile');

                location.replace(result.payment.longurl)
            }
            else
            {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "Payment not complete",
                }
            )}
        },
        error: function (err)
        {
            $('#prev').trigger('click');
            $('#prev').trigger('click');
            $(".invalid-div span").html('');
            for (let v1 of Object.keys( err.responseJSON.errors)) {
                $(".invalid-div ."+v1).html(Object.values(err.responseJSON.errors[v1]));
            }
        }
    });
}

// add selected class
function thisTime(i,time)
{
    $(".time").removeClass('active');
    $('.timing'+i).addClass('active');
    $('input[name=time]').val(time);
}

$('.datePicker').datepicker({
    dateFormat: "yy-mm-dd",
    minDate: 'today',
    showOn: "both",
    buttonImage: "/assets/images/calendar.png",
    buttonImageOnly: true,
});

function buySubscription()
{
    if($('#age').val() < 18 && $('#age').val() != ''){
        if($('input[name=guardian_name]').val() == '' || $('input[name=guardian_phone]').val() == ''){
            if($('input[name=guardian_name]').val() == '' || $('input[name=guardian_phone]').val() == ''){
                $('#details_screen_button').trigger('click');
                $(".guardian_name").html('Guardian details are required.');
                $(".guardian_phone").html('Guardian details are required.');
            }
            return false;
        }
    }

    var formData = new FormData($('#thisform')[0]);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: base_url + '/buySubscription',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (result)
        {
            
            if (result.success == true)
            {
                location.replace(result.payment.longurl)
            }
            else
            {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "Payment not complete",
                }
            )}
        },
        error: function (err)
        {
            $('#details_screen_button').trigger('click');
            $(".invalid-div span").html('');
            for (let v1 of Object.keys( err.responseJSON.errors)) {
                $(".invalid-div ."+v1).html(Object.values(err.responseJSON.errors[v1]));
            }
        }
    });
}

$('#payment_screen_button').click(function(){
    seeData('#payment-screen');
    $("#payment_screen_button").addClass("d-none");
    $("#payment").removeClass("d-none");
    $('#details_screen_button').attr('disabled', false);
});

$('#details_screen_button').click(function(){
    seeData('#details-screen');
    $("#payment").addClass("d-none");
    $("#payment_screen_button").removeClass("d-none");
    $('#details_screen_button').attr('disabled', true);
});