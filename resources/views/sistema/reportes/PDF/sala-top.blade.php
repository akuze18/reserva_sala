@extends('marco.reporte')

@section('titulo')
    sala-top
@endsection

@section('contenido')
    <table class="table">
        <thead>
        <tr>
            <th class="text-center" colspan="3">
                <h3 class="panel-title">Reporte de Salas mas Activas</h3>
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
            <th class="col-md-5">Sala</th>
            <th>Edificio</th>
            <th>Cantidad de Solicitudes</th>
        </tr>
        </thead>
        <tbody>
        @foreach($info as $sala)
            <tr>
                <td>
                    Sala {{$sala->name}}
                </td>
                <td>
                    Edificio {{$sala->piso->edificio->name}}
                </td>
                <td>
                    {{$sala->usos_count}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
