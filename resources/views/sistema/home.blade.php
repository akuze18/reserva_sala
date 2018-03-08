@extends('marco.sistema2')

@section('titulo')
    RTE | Sistema | Mi Perfil
@endsection

@section('panelIzq')
    <div class="nav-item">
        <a class="nav-link" href="#">
            <span class="nav-link-text">Fecha Actual: <label id="fechaActual">{{date('Y-M-d')}}</label></span><br>
            <span class="nav-link-text">Hora Actual: <label id="horaActual">{{date('H:i')}}</label></span>
        </a>
    </div>
@endsection

@section('titulo_contenido')
    Mi Perfil
@endsection
@section('contenido')

    <ul class="list-group ">
        <li class="list-group-item list-group-item-info">Nombre</li>
        <li class="list-group-item">{{ ActualUser()->name }}</li>
        <li class="list-group-item list-group-item-info">Rut</li>
        <li class="list-group-item">{{ ActualUser()->rut }}</li>
        <li class="list-group-item list-group-item-info">Email</li>
        <li class="list-group-item">{{ ActualUser()->email }}</li>
        <li class="list-group-item list-group-item-info">Perfil</li>
        <li class="list-group-item">{{ ActualUser()->roles[0]->name }}</li>
    </ul>
    <p></p>
    @permission('editpass.perfil')
        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalclave">
            Cambiar Clave
        </button>
        @include('modals.cambio_clave')
    @endpermission
@endsection

@section('otros_js')
    <script type="text/javascript">
        /*Corregir fecha del server cargada con PHP por la fecha del computador*/
        $(document).ready(function(){
            var d = new Date();
            var fechaActual = addZero(d.getDate())+'-'+addZero(d.getMonth()+1)+'-'+d.getFullYear();
            var horaActual = addZero(d.getHours())+':'+addZero(d.getMinutes());
            $("#fechaActual").html(fechaActual);
            $("#horaActual").html(horaActual);
            @if($errors->has('password'))
                $('#modalclave').modal('show');
            @endif
        });
        function addZero(i) {
            return (i<10?'0':'')+i;
        }
    </script>
@endsection