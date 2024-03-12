<!-- jQuery -->
<script src="{{ url('assets_admin/js/jquery.min.js')}}"></script>

<!-- Bootstrap Core JS -->
<script src="{{ url('assets_admin/js/popper.min.js')}}"></script>
<script src="{{ url('assets_admin/js/bootstrap.min.js')}}"></script>
<style type="text/css">
    .timeSlotRow > .active{
        background: #00adab82 !important;
        padding: 4px;
    }
    .time{
        background: #e8e8e8;
        padding: 4px;
    }
</style>
<script type="text/javascript">
    $('#dateslot').change(function () {
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

function thisTime(i,time)
{
    $(".time").removeClass('active');
    $('.timing'+i).addClass('active');
    $('input[name=time]').val(time);
}
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

@if(Route::is(['pagee']))
    <script src="{{ url('assets_admin/plugins/raphael/raphael.min.js')}}"></script>
    <script src="{{ url('assets_admin/plugins/morris/morris.min.js')}}"></script>
    <script src="{{ url('assets_admin/js/chart.morris.js')}}"></script>
@endif

<!-- Select2 JS -->
	<script src="{{ url('assets_admin/js/select2.min.js')}}"></script>

<!-- Datetimepicker JS -->
	<script src="{{ url('assets_admin/js/moment.min.js')}}"></script>
	<script src="{{ url('assets_admin/js/bootstrap-datetimepicker.min.js')}}"></script>

<!-- Datetimepicker JS -->
    <script  src="{{ url('assets_admin/js/jquery.nicescroll.min.js')}}"></script>

<!-- Datatables JS -->
    <script type="text/javascript" src="{{ url('assets_admin/js/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets_admin/js/pdfmake.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets_admin/js/vfs_fonts.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets_admin/js/sweetalert2@10.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/plugins/fancybox/jquery.fancybox.min.js')}}"></script>

    <script src="{{ url('assets_admin/js/summernote-bs4.js') }}"></script>

    @yield('js')

    <script src="{{ url('assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ url('assets_admin/js/jquery.timepicker.min.js') }}"></script>

    <script src="{{ url('assets_admin/js/flatpickr.js') }}"></script>
<!-- Custom JS -->
	<script  src="{{ url('assets_admin/js/script.js')}}"></script>
	<script  src="{{ url('assets_admin/js/stisla.js')}}"></script>
	<script  src="{{ url('assets_admin/js/admin_custom.js')}}"></script>
