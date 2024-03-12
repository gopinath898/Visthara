<link href="{{ url('assets/css/bootstrap.min.css') }}" rel="stylesheet">

<link rel="stylesheet" href="{{ url('assets/css/boxicons.min.css') }}">

<link rel="stylesheet" href="{{ url('assets/css/slick-theme.min.css') }}" />

<link rel="stylesheet" href="{{ url('assets/css/slick.css') }}" />

<link rel="shortcut icon" type="image/x-icon" href="{{$setting->favicon}}">

<link rel="stylesheet" type="text/css" href="{{ asset('assets_admin/css/datatables.min.css') }}" />

<link rel="stylesheet" href="{{url('assets/plugins/fancybox/jquery.fancybox.min.css')}}">

<script type="text/javascript" src="{{ url('assets_admin/js/sweetalert2@10.js') }}"></script>

<link rel="stylesheet" href="{{ url('assets/css/style.css') }}">



<link rel="stylesheet" href="{{ url('web/assets/css/bootstrap.min.css')}}">

<link rel="stylesheet" href="{{ url('web/assets/css/gallerySheet.css')}}">
        <!-- Animate CSS --> 
<link rel="stylesheet" href="{{ url('web/assets/css/animate.min.css')}}">
<!-- Meanmenu CSS -->
<link rel="stylesheet" href="{{ url('web/assets/css/meanmenu.css')}}">
<!-- Boxicons CSS -->
<link rel="stylesheet" href="{{ url('web/assets/css/boxicons.min.css')}}">
<!-- Flaticon CSS -->
<link rel="stylesheet" href="{{ url('web/assets/css/flaticon.css')}}">
<!-- Odometer CSS -->
<link rel="stylesheet" href="{{ url('web/assets/css/odometer.min.css')}}">
<!-- Slick Min CSS -->
<link rel="stylesheet" href="{{ url('web/assets/css/slick.min.css')}}">
<!-- Nice Select CSS -->
<!-- <link rel="stylesheet" href="{{ url('web/assets/css/nice-select.min.css')}}"> -->
<!-- Carousel CSS -->
<link rel="stylesheet" href="{{ url('web/assets/css/owl.carousel.min.css')}}">
<!-- Carousel Default CSS -->
<link rel="stylesheet" href="{{ url('web/assets/css/owl.theme.default.min.css')}}">
<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="{{ url('web/assets/css/magnific-popup.min.css')}}">
<!-- Fancybox CSS -->
<link rel="stylesheet" href="{{ url('web/assets/css/fancybox.min.css')}}">
<!-- Style CSS -->
<link rel="stylesheet" href="{{ url('web/assets/css/style.css')}}">
<!-- Dark CSS -->
<link rel="stylesheet" href="{{ url('web/assets/css/dark.css')}}">
<!-- Responsive CSS -->
<link rel="stylesheet" href="{{ url('web/assets/css/responsive.css')}}">
<!-- Select2 CSS -->
<link rel="stylesheet" type="text/css" href="{{asset('assets_admin/css/select2.min.css')}}">
<!-- Datepicker CSS -->
<link rel="stylesheet" href="{{asset('assets/plugins/datepicker/jquery-ui.min.css')}}">
@yield('css')

<input type="hidden" name="rtl_direction" class="rtl_direction" value="{{ session('direction') == 'rtl' ? 'true' : 'false' }}">

<style>
    :root{
        --site_color : <?php echo $setting->website_color; ?>;
        --site_color_hover : <?php echo $setting->website_color.'e8'; ?>;
    }
</style>

@if (session('direction') == 'rtl')
    <link rel="stylesheet" href="{{ url('assets/css/rtl_direction.css')}}" type="text/css">
@endif