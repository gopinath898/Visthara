"use strict";
var base_url = $('input[name=base_url]').val();

$(window).on('load', function () {
    if($('#loader').length > 0) {
        $('#loader').delay(350).fadeOut('slow');
        $('body').delay(500).css({ 'overflow': 'visible' });
    }
})

$(".add-favourite").click(function () 
{
    $(this).toggleClass("active");
    if ($(this).find("i").hasClass("bx-bookmark-heart") && $(this).hasClass("active")) 
    {
        $(this).find("i").removeClass("bx-bookmark-heart");
        $(this).find("i").addClass("bxs-bookmark-heart");
    } 
    else if ($(this).find("i").hasClass("bxs-bookmark-heart")) 
    {
        $(this).find("i").removeClass("bxs-bookmark-heart");
        $(this).find("i").addClass("bx-bookmark-heart");
    }
    var doctor_id = $(this).attr('data-id');
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: base_url + '/addBookmark/'+doctor_id,
        success: function (result)
        {
            if(result.success == false)
                window.location.href = base_url+'/patient-login';
            else
            {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                Toast.fire({
                    icon: 'success',
                    title: result.msg
                })
            }
        },
        error: function (err) {

        }
    });
});

$(document).ready(function () {
    addactiveclass(".edit-profile-menu li.user-profile-link", "active");
    addactiveclass(".single-nav ul li", "active");
    addactiveclass(".slotes .time", "active");

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#img_preview1").css(
                    "background-image",
                    "url(" + e.target.result + ")"
                );
                $("#img_preview1").hide();
                $("#img_preview1").fadeIn(650);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imageUpload").change(function () {
        readURL(this);
    });

    function readURL1(input) 
    {
        if (input.files && input.files[0]) 
        {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.avta-prview-1').css('background-image', 'url(' + e.target.result + ')');
                $('.avta-prview-1').hide();
                $('.avta-prview-1').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#image1").change(function () {
        readURL1(this);
    });

    function readURL2(input) 
    {
        if (input.files && input.files[0]) 
        {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.avta-prview-2').css('background-image', 'url(' + e.target.result + ')');
                $('.avta-prview-2').hide();
                $('.avta-prview-2').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#image2").change(function () {
        readURL2(this);
    });

    function readURL3(input) 
    {
        if (input.files && input.files[0]) 
        {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.avta-prview-3').css('background-image', 'url(' + e.target.result + ')');
                $('.avta-prview-3').hide();
                $('.avta-prview-3').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#image3").change(function () {
        readURL3(this);
    });
});

function seeData(id) 
{
    $(id).addClass("disp-block");
    $(id).siblings().removeClass("disp-block");
    $(id).siblings().addClass("disp-none");
}

function addactiveclass(id, classname) 
{
    $(id).click(function () {
        $(this).addClass(classname);
        $(this).siblings().removeClass(classname);
    });
}

var datatable = $('.datatable').DataTable({
    language: {
        paginate: {
        previous: "<i class='fa fa-angle-left'>",
        next: "<i class='fa fa-angle-right'>",
        first: "<i class='fa fa-angle-double-left'>",
        last: "<i class='fa fa-angle-double-right'>",
        }
    },
    pagingType: "full_numbers",
});

// Display Appointment
function show_appointment(appointment_id, session_id) 
{
    $('.patient_name').text('');
    $('.appointment_id').text('');
    $('.doctor_name').text('');
    $('.amount').text('');
    $('.payment_status').text('');
    $('.payment_type').text('');
    $('.illness_info').text('');
    $('.patient_address').text('');
    $('.patient_age').text('');
    $('.date').text('');
    $('.time').text('');

    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: base_url + '/show_appointment/'+appointment_id+'/'+session_id,
        success: function (result)
        {
            $('.patient_name').text(result.data.patient_name);
            $('.appointment_id').text(result.data.appointment_id);
            $('.amount').text(result.currency+result.data.amount);
            if(result.data.payment_status == 0)
            {
                $('.payment_status').text('payment not complete')
            }
            else
            {
                $('.payment_status').text('payment complete')
            }
            $('.payment_type').text(result.data.payment_type);
            $('.illness_info').text(result.data.illness_information);
            $('.patient_address').text(result.data.patient_address);
            $('.patient_age').text(result.data.age);
            $('.date').text(result.data.date);
            $('.time').text(result.data.time);
            $('.doctor_name').text(result.data.doctor.name);
        },
        error: function (err) {

        }
    });
}

function appointId(id, session_id,doctor_name='')
{
    $('input[name=appointment_id]').val(id);
    $('input[name=id]').val(id);
    $('input[name=session_id]').val(session_id);
    if(doctor_name == ''){
        $('#doctor_name').hide();
    }else{
        $('input[name=doctor_name]').val(doctor_name);
        $('#doctor_name').show();
    }
}

// add review
function addReview()
{
    var formData = new FormData($('#reviewForm')[0]);
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: base_url + '/addReview',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (result)
        {
            $(".invalid-div span").html('');
            if(result.success == true)
            {
                location.reload();
            }
            else
            {
                $(".invalid-div .review").html(result.data);
            }
        },
        error: function (err) {
            $(".invalid-div span").html('');
            for (let v1 of Object.keys( err.responseJSON.errors)) {
                $(".invalid-div ."+v1).html(Object.values(err.responseJSON.errors[v1]));
            }
        }
    });
}

function cancelAppointment()
{
    var formData = new FormData($('#cancelForm')[0]);
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: base_url + '/cancelAppointment',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (result)
        {
            $(".invalid-div span").html('');
            if(result.success == true)
            {
                location.reload();
            }
            else
            {
                $(".invalid-div .review").html(result.data);
            }
        },
        error: function (err) {
            $(".invalid-div span").html('');
            for (let v1 of Object.keys( err.responseJSON.errors)) {
                $(".invalid-div ."+v1).html(Object.values(err.responseJSON.errors[v1]));
            }
        }
    });
}

function show_medicines(id) {
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: base_url + '/display_purchase_medicine/'+id,
        success: function (result) {
            if (result.success == true)
            {
                $('.shippingAt').text(result.data.shipping_at);
                if(result.data.shipping_at == 'home')
                {
                    $('.shippingAddressTr').show();
                    $('.shippingAddress').text(result.data.address.address);
                    $('.deliveryCharge').text(result.currency+result.data.delivery_charge);
                }
                else
                {
                    $('.shippingAddressTr').hide();
                }
                $('.tbody').html('');
                result.data.medicine_name.forEach(element =>
                {
                    $('.tbody').append(
                        '<tr><td>'+element.name+'</td>'+
                        '<td>'+element.qty+'</td>'+
                        '<td>'+result.currency+element.price+'</td></tr>'
                    );
                });
            }
        },
        error: function (err) {
        }
    });
}

function single_report(id) {
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: base_url + '/single_report/'+id,
        success: function (result) {
            if (result.success == true)
            {
                $('.report_id').text(result.data.report_id);
                $('.patient_name').text(result.data.patient_name);
                $('.patient_phone').text(result.data.phone_no);
                $('.patient_age').text(result.data.age);
                $('.patient_gender').text(result.data.gender);
                $('.amount').text(result.currency + result.data.amount);
                if (result.data.payment_status == 1) {
                    $('.payment_status').text('Complete');
                } else {
                    $('.payment_status').text('Not Complete');
                }
                $('.payment_type').text(result.data.payment_type);
                if (result.data.radiology_category == null) {
                    $('.radiology_category_id').hide();
                }
                else
                {
                    $('.radiology_category').text(result.data.radiology_category);
                    $('.types').html('');
                    $('.types').append(
                        '<thead><tr><th>Screening For</th>'+
                        '<th>Charge</th>'+
                        '<th>Report Days</th></tr></thead><tbody></tbody>'
                    );
                    result.data.radiology.forEach(element =>
                    {
                        $('.types tbody').append(
                            '<tr><td>'+element.screening_for+'</td>'+
                            '<td>'+result.currency+element.charge+'</td>'+
                            '<td>'+element.report_days+'</td></tr>'
                        );
                    });
                }

                if (result.data.pathology_category == null) {
                    $('.pathology_category_id').hide();
                    $('.patho_test_type').hide();
                }
                else
                {
                    $('.pathology_category').text(result.data.pathology_category);
                    $('.types').html('');
                    $('.types').append(
                        '<thead><tr><th>Test Name</th>'+
                        '<th>Charge</th>'+
                        '<th>Report Days</th>'+
                        '<th>Method</th></tr></thead><tbody></tbody>'
                    );
                    result.data.pathology.forEach(element =>
                    {
                        $('.types tbody').append(
                            '<tr><td>'+element.test_name+'</td>'+
                            '<td>'+result.currency+element.charge+'</td>'+
                            '<td>'+element.report_days+'</td>'+
                            '<td>'+element.method+'</td></tr>'
                        );
                    });
                }
            }
        },
        error: function (err) {
        }
    });
}

$('.add-attachment').click(function(){
    var attachmentcontent = `<input class="mt-2" type='file' id="attachment" name="attachment[]" accept=".png, .jpg, .jpeg, .pdf, .doc" />`;
    $(".attachment-info").append(attachmentcontent);
    return false;
});

function uploadDocument()
{
    var formData = new FormData($('#attachmentForm')[0]);
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: base_url + '/uploadDocument',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (result)
        {
            $(".invalid-div .attachment").html('');
            if(result.success == true)
            {
                location.reload();
            }
            else
            {
                $(".invalid-div .review").html(result.data);
            }
        },
        error: function (err) {
            $(".invalid-div .attachment").html('');
            for (let v1 of Object.keys( err.responseJSON.errors)) {
                $(".invalid-div ."+v1).html(Object.values(err.responseJSON.errors[v1]));
            }
        }
    });
}

function show_sessions(appointment_id) {
    seeData('#session-details');
    $('.session-details tbody').html('');
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: base_url + '/show_sessions/'+appointment_id,
        success: function (result)
        {
            if(result.data == ''){
                $('.session-details tbody').html(`No results found`);
            }
            result.data.forEach((element, index) =>
            {
                let action = '';
                let booked_on = '';
                let status = element.session_status.charAt(0).toUpperCase() + element.session_status.slice(1);
                if(element.session_status == 'pending'){
                    action = `<a onclick="book_session(${element.id}, ${element.doctor_id}, ${appointment_id})" href="javascript:void(0)" role="button" data-from="add_new" data-bs-toggle="modal" data-bs-target="#book_session" class="btn btn-sm btn-info">Book Now</a>`;
                }
                else if(element.session_status == 'booked'){
                    action = `<a href="${element.zoomurl}" class="btn btn-sm btn-primary" style="display: block ruby;"><span><i class="fa fa-video"></i> Call</span>`
                    booked_on = element.session_date+' '+element.session_timeslot;
                }

                $('.session-details tbody').append(
                    `<tr>
                        <td>${index+1}</td>
                        <td>${element.appointment_id}</td>
                        <td>${status}</td>
                        <td>${booked_on}</td>
                        <td>${action}</td>
                    </tr>`
                );
            });
        },
        error: function (err) {

        }
    });
    
}

function book_session(id,appointment_id){
    $('#session_id').val(id);
    $('#appointment_id').val(appointment_id);
}

// display timeslot
$('#date').change(function () {
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        data:{
            date:this.value,
            doctor_id:$('select[name=doctor_id]').val(),
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
                        $('.timeSlotRow').append(`<input type="hidden" name="time" value="${value.start_time}-${value.end_time}">`);
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

// add selected class
function thisTime(i,time)
{
    $(".time").removeClass('active');
    $('.timing'+i).addClass('active');
    $('input[name=time]').val(time);
}

function view_attachments(appointment_id) {
    $('.attachments-error').html('');
    $('.attachments').html('');
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: base_url + '/view_attachments/'+appointment_id,
        success: function (result)
        {
            if(result.success){
                if(result.data.length){
                    result.data.forEach(element => {
                        let name = element.document_name.split('.');
                        let extension = name[1];
                        var str=`<tr>
                            <td>`
                            if($.inArray(extension, ['png', 'jpg', 'jpeg']) == -1){
                                str+=`<a href="${element.document}" data-fancybox data-type="iframe" download>
                                    <iframe src="${element.document}" width="150px" height="150px"></iframe>
                                </a>`;
                            }
                            else{
                                str+=`<a href="${element.document}" data-fancybox="gallery2" target="_blank" download>
                                    <img src="${element.document}" alt="Feature Image" width="150px" height="150px">
                                </a>`;
                            }
                        str+=`
                            </td>
                            <td>${element.document_name}</td>
                        </tr>`;
                        
                        $('.attachments').append(str);
                    });
                }
                else{
                    $('.attachments-error').html('No Documents Found.')
                }
            }
            
        },
        error: function (err) {
            $('.attachments-error').html(err.responseJSON.message);
        }
    });
}

$('.datePicker').datepicker({
    dateFormat: "yy-mm-dd",
    minDate: 'today',
    showOn: "both",
    buttonImage: "/assets/images/calendar.png",
    buttonImageOnly: true,
});