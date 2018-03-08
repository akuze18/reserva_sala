<!DOCTYPE html>
<html lang="es">
<head>
    <title>@yield('titulo','RTE | Sistema')</title>
    <!-- Required meta tags -->
    <meta charset="utf-8"> <!-- En esta forma la pagina leera las tildes y caracteres especiales de espa�ol -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="shortcut icon" href="{{ url('/img/favicon.ico')}}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="{{ url('/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{ url('/sistema/css/bootstrap.min.css')}}?v={{date('YmdHis')}}">
    <link rel="stylesheet" href="{{ url('/sistema/css/estilos.css')}}?v={{date('YmdHis')}}">
    <link rel="stylesheet" href="{{ url('/sistema/css/bootstrap.colors.css')}}?v={{date('YmdHis')}}">
    <link rel="stylesheet" href="{{ url('/sistema/css/mod-bootstrap.css')}}?v={{date('YmdHis')}}">
    <link rel="stylesheet" href="{{ url('/sistema/SweetAlert2/sweetalert2.css')}}">
</head>
<body oncontextmenu="return true" >
    <!-- menu -->
    @include('marco.partes.nav')
    <!-- fin menu -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 dimension">
                @yield('panelIzq')
            </div>
            <div class="col-md-7">
                @yield('contenido')
            </div>
            <div class="col-md-2">
                @yield('panelDer')
            </div>
        </div>
    </div>

    @include('marco.partes.footer')
    <!-- jQuery Primero, luego Tether, despues Bootstrap JS. -->
    <script src="{{url('sistema/SweetAlert2/sweetalert2.min.js')}}"></script>
    <script src="{{url('sistema/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{url('sistema/js/misjquery.js')}}"></script>
    <script src="{{url('sistema/js/tether.min.js')}}"></script>
    <script src="{{url('sistema/js/bootstrap.min.js')}}"></script>
    @include('marco.partes.mensajes')
    @yield('otros_js')

</body>
</html>
