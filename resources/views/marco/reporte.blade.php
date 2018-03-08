<!DOCTYPE html>
<html lang="es">
<head>
    <title>@yield('titulo','RTE | Sistema')</title>
    <!-- Required meta tags -->
    <meta charset="utf-8"> <!-- En esta forma la pagina leera las tildes y caracteres especiales de espa�ol -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="{{ url('vendor/sistema/css/bootstrap3.min.css')}}?v={{date('YmdHis')}}">
    <link rel="stylesheet" href="{{ url('vendor/sistema/css/estilos.css')}}?v={{date('YmdHis')}}">
    <link href="{{url("css/mis-mod.css")}}" rel="stylesheet">
    <link href="{{url("css/bootstrap.colors.css")}}" rel="stylesheet">
</head>
<body>
    <div class="jumbotron">
        <div class="">
            @yield('contenido')
        </div>
    </div>
</body>
</html>
