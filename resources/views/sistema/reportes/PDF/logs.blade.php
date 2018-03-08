@extends('marco.reporte')

@section('titulo')
    logs
@endsection

@section('contenido')
    <table class="table">
        <thead>
            <tr>
                <th class="text-center" colspan="6">
                    <h3>Log del Sistema</h3>
                </th>
            </tr>
        </thead>
        <thead>
            <tr>
                <th class="text-center" colspan="3">
                    <h4>Desde : {{$desde}}</h4>
                </th>
                <th class="text-center" colspan="3">
                    <h4>Hasta : {{$hasta}}</h4>
                </th>
            </tr>
        </thead>
        <thead>
            <tr>
                <th>Modulo</th>
                <th>Accion</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th>ID afectado</th>
                <th>Motivo</th>
            </tr>
        </thead>
        <tbody>
        @foreach($info as $log)
            <tr>
                <td>{{$log->modulo}}</td>
                <td>{{$log->accion}}</td>
                <td>{{$log->user->name}}</td>
                <td>{{$log->fecha}}</td>
                <td>{{($log->object_id?$log->object_id:'')}}</td>
                <td>{{($log->motivo?$log->motivo->full_name:'')}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection