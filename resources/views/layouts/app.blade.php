<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicon/'. $configuracion->favicon) }}">
  <link rel="icon" type="image/png" href="{{ asset('favicon/'. $configuracion->favicon) }}">
  <title>
    @yield('template_title') - {{$configuracion->nombre_sistema}}
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('assets/css/nucleo-icons.css')}}" rel="stylesheet" />
  <link href="{{ asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css?v=2.0.4')}}" rel="stylesheet" />


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.dataTables.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css?v=2.0.4')}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
      .legal-shell{
        background: #F4F1EA !important;
        color: #1F2328;
      }

      .legal-shell-bg{
        display: none !important;
      }

      .legal-shell .main-content{
        background: #F4F1EA;
        min-height: 100vh;
      }

      .legal-shell .container-fluid.py-4{
        padding-top: 1.25rem !important;
      }

      .legal-sidenav{
        border-radius: 0 !important;
        box-shadow: none !important;
        border-right: 1px solid #D8D2C6 !important;
        background: #FBFAF6 !important;
        margin-top: 0 !important;
        margin-bottom: 0 !important;
        margin-left: 0 !important;
        height: 100vh;
      }

      .legal-sidenav .sidenav-header{
        height: auto;
        padding: 1.35rem 1.5rem 1.15rem;
      }

      .legal-sidenav .navbar-brand{
        padding: 0;
      }

      .legal-sidenav .navbar-brand-img{
        max-height: 36px;
      }

      .legal-sidenav .horizontal{
        margin: 0 1.5rem 1rem !important;
        background-color: #D8D2C6;
      }

      .legal-sidenav .navbar-nav{
        padding: 0 1rem;
      }

      .legal-sidenav .nav-link{
        border-radius: 0 !important;
        margin: 0;
        padding: .85rem .35rem !important;
        color: #5E625E !important;
        font-weight: 600;
        border-bottom: 1px solid transparent;
        box-shadow: none !important;
      }

      .legal-sidenav .nav-link.active{
        background: transparent !important;
        color: #1F2328 !important;
        border-bottom-color: #8A6F3E;
      }

      .legal-sidenav .nav-link:hover{
        color: #1F2328 !important;
      }

      .legal-sidenav .nav-link-text{
        margin-left: 0 !important;
      }

      .legal-sidenav h6{
        padding-left: .35rem !important;
        margin-left: 0 !important;
        margin-top: 1.4rem;
        margin-bottom: .35rem;
        letter-spacing: .14em;
        color: #8B857C !important;
      }

      .legal-navbar{
        margin-top: 0 !important;
        padding-top: .75rem !important;
        padding-bottom: .75rem !important;
        background: transparent !important;
      }

      .legal-breadcrumb a,
      .legal-breadcrumb .breadcrumb-item,
      .legal-breadcrumb .breadcrumb-item.active{
        color: #6F6A62 !important;
        font-weight: 600;
      }

      .legal-navbar .sidenav-toggler-line{
        background: #1F2328 !important;
      }

      .legal-user-menu{
        border: 1px solid #BFB7A8 !important;
        color: #1F2328 !important;
        background: transparent !important;
        border-radius: 0 !important;
        font-weight: 700;
      }
    </style>
    @yield('css')
  {{-- <style>
        input:before {
            content: attr(data-date);
            display: inline-block;
            color: black;
        }

        input::-webkit-datetime-edit, input::-webkit-inner-spin-button, input::-webkit-clear-button {
            display: none;
        }

    </style> --}}
  @livewireStyles


</head>

<body class="g-sidenav-show bg-gray-100 legal-shell">
  <div class="min-height-300 position-absolute w-100 legal-shell-bg"></div>

   <!-- Sidenav -->
    @include('layouts.sidebar')

  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    @include('layouts.navbar')
    <!-- End Navbar -->

    <div class="container-fluid py-4">

        {{-- @include('layouts.header') --}}

        @yield('content')


       <!-- Modal lateral Congif -->
        @include('layouts.footer')
      <!-- End Modal lateral Congif -->

    </div>
  </main>


   <!-- Modal lateral Congif -->
    {{-- @include('layouts.modal_config') --}}
  <!-- End Modal lateral Congif -->

  <!--   Core JS Files   -->
  <script src="{{ asset('assets/js/core/popper.min.js')}}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js')}}"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
  <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
  <script src="{{ asset('assets/js/plugins/fullcalendar.min.js')}}"></script>
  <!-- Kanban scripts -->
  <script src="{{ asset('assets/js/plugins/dragula/dragula.min.js')}}"></script>
  <script src="{{ asset('assets/js/plugins/jkanban/jkanban.js')}}"></script>
  <script src="{{ asset('assets/js/plugins/chartjs.min.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js"></script>

  @yield('js_custom')


  <script>
            if (document.getElementById('edit-deschiption')) {
            var quill = new Quill('#edit-deschiption', {
                theme: 'snow' // Specify theme in configuration
            });
            };

            if (document.getElementById('choices-category')) {
            var element = document.getElementById('choices-category');
            const example = new Choices(element, {
                searchEnabled: false
            });
            };

            if (document.getElementById('choices-sizes')) {
            var element = document.getElementById('choices-sizes');
            const example = new Choices(element, {
                searchEnabled: false
            });
            };

            if (document.getElementById('choices-currency')) {
            var element = document.getElementById('choices-currency');
            const example = new Choices(element, {
                searchEnabled: false
            });
            };

            if (document.getElementById('choices-tags')) {
            var tags = document.getElementById('choices-tags');
            const examples = new Choices(tags, {
                removeItemButton: true
            });


            examples.setChoices(
                [{
                    value: 'One',
                    label: 'Expired',
                    disabled: true
                },
                {
                    value: 'Two',
                    label: 'Out of Stock',
                    selected: true
                }
                ],
                'value',
                'label',
                false,
            );
            }

        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
          var options = {
            damping: '0.5'
          }
          Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }

  </script>


  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('assets/js/argon-dashboard.min.js?v=2.0.4')}}"></script>
  @livewireScripts
</body>

</html>
