<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Bootstrap Css -->
    <link href="{{asset('assets/libs/bootstrap/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/libs/toastr/build/toastr.min.css') }}">



    <!-- Styles -->

</head>
<body  class="auth-body-bg">
<div id="app">
        <!-- <main class="py-4"> -->
            @yield('content')
        <!-- </main> -->
        @if (session('error'))
        <script>
            $(document).ready(function() {
                toastr.error('{{ session('error') }}', 'Error!', {
                    closeButton: true,
                    // progressBar: true,
                });
            });
        </script>
    @endif
</div>



    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/toastr/build/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    


    <script src="{{ asset('assets/js/app.js') }}"></script>
@yield('js-script')

@stack('js')

   



</body>
</html>
