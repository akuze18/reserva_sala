@extends('marco.reporte')

@section('titulo')
    solicitante-top
@endsection

@section('contenido')
    <table class="table">
        <thead>
        <tr>
            <th class="text-center" colspan="3">
                <h3 class="panel-title">Reporte de Solicitantes más Activos</h3>
            </th>
        </tr>
        </thead>
        <thead>
        <tr>
            <th class="text-center">
                <h4 class="panel-title">Desde : {{$desde}}</h4>
            </th>
            <th class="text-center" colspan="2">
                <h4 class="panel-title">Hasta : {{$hasta}}</h4>
            </th>
        </tr>
        </thead>
        <thead>
        <tr>
            <th class="col-md-4">Perfil</th>
            <th>Nombre</th>
            <th>Cantidad de Solicitudes</th>
        </tr>
        </thead>
        <tbody>
        @foreach($info as $user)
            <tr>
                <td>
                    {{$user->roles[0]->name}}
                </td>
                <td>
                    {{$user->name}}
                </td>
                <td>
                    {{$user->usos_count}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
