<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Transtila | Soluções Integradas em Logística e Armazenagem</title>
  <!--favicon-->
  <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png">
  <!-- loader-->
  <link href="assets/css/pace.min.css" rel="stylesheet">
  <script src="assets/js/pace.min.js"></script>

  <!--plugins-->
  <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/metismenu/metisMenu.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/metismenu/mm-vertical.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/notifications/css/lobibox.min.css') }}">
  <!--bootstrap css-->
  <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
  <!--main css-->
  <link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
  <link href="{{ asset('sass/main.css') }}" rel="stylesheet">
  <link href="{{ asset('sass/dark-theme.css') }}" rel="stylesheet">
  <link href="{{ asset('sass/blue-theme.css') }}" rel="stylesheet">
  <link href="{{ asset('sass/semi-dark.css') }}" rel="stylesheet">
  <link href="{{ asset('sass/bordered-theme.css') }}" rel="stylesheet">
  <link href="{{ asset('sass/responsive.css') }}" rel="stylesheet">

</head>

{{--
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', config('app.name'))</title>

  <link rel="stylesheet" href="{{ asset('vendor/maxton/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/maxton/css/bootstrap-extended.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/maxton/css/horizontal-menu.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/maxton/css/style.css') }}">

  @vite(['resources/css/app.css','resources/js/app.js'])
  @stack('styles')
</head> --}}




<body class="pace-done">
  <div class="wrapper">
    {{-- Topbar --}}
    @includeIf('partials.topbar')
    {{-- Sidebar --}}
    @includeIf('partials.sidebar')
    {{-- Main Content --}}
    <main class="page-content">
      @yield('content')
    </main>
    {{-- Footer --}}
    @includeIf('partials.footer')
  </div>

  <!--bootstrap js-->
  <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

  <!--plugins-->
  <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
  <!--plugins-->
  <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
  <script src="{{ asset('assets/plugins/metismenu/metisMenu.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/peity/jquery.peity.min.js') }}"></script>
  <!--notification js -->
  <script src="{{ asset('assets/plugins/notifications/js/lobibox.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/notifications/js/notifications.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/notifications/js/notification-custom-script.js') }}"></script>
  <script src="{{ asset('assets/js/sweetalert2.js') }}"></script>
  <script>
    $(".data-attributes span").peity("donut")
  </script>
  <script src="{{ asset('assets/js/main.js') }}"></script>
  <script src="{{ asset('assets/js/dashboard1.js') }}"></script>
  <script>
    new PerfectScrollbar(".user-list")
  </script>

  <script>
    $(document).ready(function () {
      @foreach(['success', 'error', 'warning', 'info', 'default'] as $msg)
        @if(session($msg))
          show_noti("{{ $msg }}", "{{ session($msg) }}");
        @endif
      @endforeach
});
  </script>

  @yield('script')

</body>

</html>