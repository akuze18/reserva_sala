@extends('marco.reporte')

@section('titulo')
    carrera-top
@endsection

@section('contenido')
    <table class="table">
        <thead>
        <tr>
            <th class="text-center" colspan="2">
                <h3 class="panel-title">Reporte de Carreras más Activas</h3>
            </th>
        </tr>
        </thead>
        <thead>
        <tr>
            <th class="text-center">
                <h4 class="panel-title">Desde : {{$desde}}</h4>
            </th>
            <th class="text-center">
                <h4 class="panel-title">Hasta : {{$hasta}}</h4>
            </th>
        </tr>
        </thead>
        <thead>
            <tr>
                <th class="col-md-7">Carrera</th>
                <th>Cantidad de Solicitudes</th>
            </tr>
        </thead>
        <tbody>
        @foreach($info as $carrera)
            <tr>
                <td>
                    {{$carrera->name}}
                </td>
                <td>
                    {{$carrera->usos_count}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
