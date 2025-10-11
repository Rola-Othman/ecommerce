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
    <meta name="csrf-token" content="{{ csrf_token() }}" />

<link rel="icon" type="image/png" href="{{ $logoSetting->favicon }}">
    <link rel="stylesheet" href="{{ asset('frotend/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frotend/css/bootstrap.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('frotend/css/css/select2.min.css') }}"> --}}
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
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/select2/dist/css/select2.min.css') }}">

    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link rel="stylesheet" href="{{ asset('frotend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frotend/css/responsive.css') }}">
    <!-- <link rel="stylesheet" href="css/rtl.css"> -->
    @if ($settings->layout === 'RTL')
        <link rel="stylesheet" href="{{ asset('frotend/css/rtl.css') }}">
    @endif
    <script>
        const USER = {
            id: "{{ auth()->user()->id }}",
            name: "{{ auth()->user()->nmae }}",
            image: "{{ asset(auth()->user()->image) }}"
        }
    </script>
        @vite(['resources/js/app.js', 'resources/js/frontend.js'])
</head>

<body>


    <!--=============================
    DASHBOARD MENU START
  ==============================-->
    <div class="wsus__dashboard_menu">
        <div class="wsusd__dashboard_user">
            <img src="{{ asset(auth()->user()->image) }}" alt="img" class="img-fluid">
            <p>{{ auth()->user()->name }}</p>
        </div>
    </div>
    <!--=============================
    DASHBOARD MENU END
  ==============================-->


    <!--=============================
    DASHBOARD START
  ==============================-->
    @yield('content')
    <!--=============================
    DASHBOARD START
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
    {{-- <script src="{{ asset('frotend/js/select2.min.js') }}"></script> --}}
    <script src="{{ asset('backend/assets/modules/select2/dist/js/select2.full.min.js') }}"></script>

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>
    <!--main/custom js-->
    <script src="{{ asset('frotend/js/main.js') }}"></script>
    <script>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}');
            @endforeach
        @endif
    </script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $('body').on('click', '.delete-item', function(event) {
                event.preventDefault();

                let deleteUrl = $(this).attr('href');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            type: 'DELETE',
                            url: deleteUrl,

                            success: function(data) {

                                if (data.status == 'success') {
                                    Swal.fire(
                                        'Deleted!',
                                        data.message,
                                        'success'
                                    )
                                    window.location.reload();
                                } else if (data.status == 'error') {
                                    Swal.fire(
                                        'Cant Delete',
                                        data.message,
                                        'error'
                                    )
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log(error);
                            }
                        })
                    }
                })
            })

        })
    </script>
    @stack('scripts')
</body>

</html>
