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
  <link href="{{ asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css?v=2.0.4')}}" rel="stylesheet" />

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  @livewireStyles
</head>

<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300  position-absolute w-100" style="background-color: {{$configuracion->color_principal}}!important;"></div>

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
    @include('layouts.modal_config')
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

    @yield('js_custom')

    <script type="text/javascript">

        var url = "{{ route('changeLang') }}";

        $(".changeLang").change(function(){
            window.location.href = url + "?lang="+ $(this).val();
        });

    </script>

  <script>
            var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

            gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
            gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
            gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');

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
