<!DOCTYPE html>
<html lang="es">

<head>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>RESERVA TU ESPACIO</title>

    <!-- CSS -->
    <link href="{{url('css/bootstrap.min.css')}}?v={{date('yyyymmddMMhhss')}}" rel="stylesheet" type="text/css">
    <link href="{{url('font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('css/nivo-lightbox.css')}}" rel="stylesheet" />
    <link href="{{url('css/nivo-lightbox-theme/default/default.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('css/owl.carousel.css')}}" rel="stylesheet" media="screen" />
    <link href="{{url('css/owl.theme.css')}}" rel="stylesheet" media="screen" />
    <link href="{{url('css/animate.css')}}" rel="stylesheet" />
    <link href="{{url('css/style.css')}}" rel="stylesheet">
    <link href="{{url('color/default.css')}}" rel="stylesheet">

    <link rel="shortcut icon" href="{{url('img/favicon.ico')}}" type="image/x-icon">
    <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">


</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-custom">

<!-- Section: Titulo -->
<section id="titulo" class="home-section text-center">
    <div class="container">
        <h1>Sitio : {{env('APP_NAME')}}</h1>
    </div>
</section>
<!-- /Section: Titulo -->

<!-- Section: Login -->
<section id="sistema" class="home-section text-center">
    <div class="container">
        @yield('logear')
    </div>
</section>
<!-- /Section: login -->

<!-- Footer -->
<footer>
    <div class="container">
        @yield('footerql')
    </div>
</footer>

<!-- Core JavaScript Files -->
<script src="{{url('js/jquery.min.js')}}"></script>
<script src="{{url('js/bootstrap.min.js')}}"></script>
<script src="{{url('js/jquery.easing.min.js')}}"></script>


</body>

</html>
