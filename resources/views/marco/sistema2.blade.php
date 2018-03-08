<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('titulo',env('APP_NAME'))</title>
    <link rel="shortcut icon" href="{{ url('favicon.ico')}}" type="image/x-icon">
    <!-- Bootstrap core CSS-->
    <link href="{{url("vendor/bootstrap/css/bootstrap.min.css")}}" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="{{url("vendor/font-awesome/css/font-awesome.min.css")}}" rel="stylesheet" type="text/css">
    <!-- Page level plugin CSS-->
    <link href="{{url("vendor/datatables/dataTables.bootstrap4.css")}}" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{url("css/sb-admin.css")}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('vendor/SweetAlert2/sweetalert2.css')}}">
    <link href="{{url("css/mis-mod.css")}}" rel="stylesheet">
    <link href="{{url("css/bootstrap.colors.css")}}" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
@include('marco.partes.nav-adm')
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-header">
                @yield('titulo_contenido')
            </div>
            <div class="card-body row">
                <div class="col-sm-12">@yield('contenido')</div>
            </div>
            <!--<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>-->
        </div>

    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    @include('marco.partes.footer-adm')
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fa fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="{{url("vendor/jquery/jquery.min.js")}}"></script>
    <script src="{{url("vendor/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{url("vendor/jquery-easing/jquery.easing.min.js")}}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{url("js/sb-admin.min.js")}}"></script>
    <script src="{{url('vendor/SweetAlert2/sweetalert2.min.js')}}"></script>
    @include('marco.partes.mensajes')
    @yield('otros_js')
</div>
</body>

</html>
