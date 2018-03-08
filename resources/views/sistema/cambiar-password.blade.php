@extends('marco.sistema2')

@section('titulo')
    Debe cambiar su contraseña antes de continuar
@endsection

@section('contenido')
    <table class="table">
        <thead>
            <tr>
                <th>Debe cambiar su contraseña antes de continuar</th>
            </tr>
        </thead>
    </table>

    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalclave">
        Cambiar Clave
    </button>
    @include('modals.cambio_clave')

@endsection

@section('otros_js')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#modalclave').modal('show');
        });
    </script>
@endsection