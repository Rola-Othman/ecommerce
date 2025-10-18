<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>
        @yield('title')
    </title>
     @yield('metas')
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="icon" type="image/png" href="{{ asset($logoSetting->favicon) }}">
    <link rel="stylesheet" href="{{ asset('frotend/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frotend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frotend/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frotend/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('frotend/css/jquery.nice-number.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frotend/css/jquery.calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('frotend/css/add_row_custon.css') }}">
    <link rel="stylesheet" href="{{ asset('frotend/css/mobile_menu.css') }}">
    <link rel="stylesheet" href="{{ asset('frotend/css/jquery.exzoom.css') }}">
    <link rel="stylesheet" href="{{ asset('frotend/css/multiple-image-video.css') }}">
    <link rel="stylesheet" href="{{ asset('frotend/css/ranger_style.css') }}">
    <link rel="stylesheet" href="{{ asset('frotend/css/jquery.classycountdown.css') }}">
    <link rel="stylesheet" href="{{ asset('frotend/css/venobox.min.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link rel="stylesheet" href="{{ asset('frotend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frotend/css/responsive.css') }}">
    @if ($settings->layout === 'RTL')
        <link rel="stylesheet" href="{{ asset('frotend/css/rtl.css') }}">
    @endif
</head>

<body>

    <!--============================
        HEADER START
    ==============================-->
    @include('frontend.layouts.header')
    <!--============================
        HEADER END
    ==============================-->

    <!--============================
         MENU START
    ==============================-->
    @include('frontend.layouts.menu')
    <!--============================
         MENU END
    ==============================-->

    <!--==========================
        POP UP START
    ===========================-->
   
    <section class="product_popup_modal">
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content product-modal-content">

                </div>
            </div>
        </div>
    </section>
    <!--==========================
        POP UP END
    ===========================-->

    <!--============================
        Main Content PART START
    ==============================-->
    @yield('content')
    <!--============================
        Main Content PART END
    ==============================-->

    <!--============================
        FOOTER PART START
    ==============================-->
    @include('frontend.layouts.footer')
    <!--============================
        FOOTER PART END
    ==============================-->


    <!--============================
        SCROLL BUTTON START
    ==============================-->
    <div class="wsus__scroll_btn">
        <i class="fas fa-chevron-up"></i>
    </div>
    <!--============================
        SCROLL BUTTON  END
    ==============================-->


    <!--jquery library js-->
    <script src="{{ asset('frotend/js/jquery-3.6.0.min.js') }}"></script>
    <!--bootstrap js-->
    <script src="{{ asset('frotend/js/bootstrap.bundle.min.js') }}"></script>
    <!--font-awesome js-->
    <script src="{{ asset('frotend/js/Font-Awesome.js') }}"></script>
    <!--select2 js-->
    <script src="{{ asset('frotend/js/select2.min.js') }}"></script>
    <!--slick slider js-->
    <script src="{{ asset('frotend/js/slick.min.js') }}"></script>
    <!--simplyCountdown js-->
    <script src="{{ asset('frotend/js/simplyCountdown.js') }}"></script>
    <!--product zoomer js-->
    <script src="{{ asset('frotend/js/jquery.exzoom.js') }}"></script>
    <!--nice-number js-->
    <script src="{{ asset('frotend/js/jquery.nice-number.min.js') }}"></script>
    <!--counter js-->
    <script src="{{ asset('frotend/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('frotend/js/jquery.countup.min.js') }}"></script>
    <!--add row js-->
    <script src="{{ asset('frotend/js/add_row_custon.js') }}"></script>
    <!--multiple-image-video js-->
    <script src="{{ asset('frotend/js/multiple-image-video.js') }}"></script>
    <!--sticky sidebar js-->
    <script src="{{ asset('frotend/js/sticky_sidebar.js') }}"></script>
    <!--price ranger js-->
    <script src="{{ asset('frotend/js/ranger_jquery-ui.min.js') }}"></script>
    <script src="{{ asset('frotend/js/ranger_slider.js') }}"></script>
    <!--isotope js-->
    <script src="{{ asset('frotend/js/isotope.pkgd.min.js') }}"></script>
    <!--venobox js-->
    <script src="{{ asset('frotend/js/venobox.min.js') }}"></script>
    <!--classycountdown js-->
    <script src="{{ asset('frotend/js/jquery.classycountdown.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!--main/custom js-->
    <script src="{{ asset('frotend/js/main.js') }}"></script>
    @include('frontend.layouts.scripts')
    @stack('scripts')
    <script>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}');
            @endforeach
        @endif
    </script>
    <script>
        $(document).ready(function() {
            $('.auto_click').click();
        })
    </script>
</body>

</html>
