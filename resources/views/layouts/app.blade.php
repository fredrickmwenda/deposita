<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/libs/bootstrap/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/libs/toastr/build/toastr.min.css') }}">
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <!--stack css process other css from pages-->
    @stack('css')
</head>
<body> 
    <div id="layout-wrapper">
        @include('layouts.partials.header')
        @include('layouts.partials.sidebar')
        <div class="main-content">
            <!-- <div class="page-content">
                <div class="container-fluid"> -->
                    @yield('content')
                <!-- </div>
            </div> -->
        </div>
        @include('layouts.partials.footer')

      
    </div>



<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/popper/popper.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/libs/toastr/build/toastr.min.js') }}"></script>
</script><script src="{{ asset('assets/js/app.js') }}"></script>
<!-- <script>
$(document).ready(function() {
    $("#s-datatable").DataTable({
        "pageLength": 25,
    
        responsive: true,
    });
});
</script> -->
@if (isset($errors) && $errors->any())
            @foreach ($errors->all() as $error)
                <script>
                    $(document).ready(function(){
                        toastr.error('{{ $error }}', 'Error', {
                            closeButton: true,
                            timeOut: 10000 
                        });
                    });
                </script>
            @endforeach
	    @endif

        @if (session('success'))
            <script>
                $(document).ready(function(){
                    toastr.success('{{ session('success') }}', 'Success', {
                        closeButton: true,
                        timeOut: 10000 
                    });
                });
            </script>
        @endif

	@if (session('message'))
		<script>
			$(document).ready(function(){
            // Show toastr notification with timeout
                toastr.success('{{ session('message') }}', 'Success', {
                    closeButton: true,
                    timeOut: 10000 // Set the timeout to 10 seconds (10000 milliseconds)
                })
			});
		</script>
	@endif

    @php
        $message = $response['message'] ?? '';
    @endphp

    @if ($message)
    <script>
        $(document).ready(function(){
            toastr.success("{{ $message }}", {
                timeOut: 10000 // Set the timeout to 10 seconds (10000 milliseconds)
            });
        });
    </script>
    @endif

	@if (session('error'))
        <script>
            $(document).ready(function() {
                toastr.error('{{ session('error') }}', 'Error!', {
                    closeButton: true,
                    timeOut: 10000 
                    // progressBar: true,
                });
            });
        </script>
    @endif


<!-- apexcharts -->

<!-- dashboard init -->


<!-- App js -->

@yield('js-script')

@stack('js')
 
</body>
</html>
