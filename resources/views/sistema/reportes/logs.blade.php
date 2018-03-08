@extends('marco.sistema2')

@section('titulo')
    Log del Sistema
@endsection

@section('panelIzq')
    <div class="nav-item">
        <div class="nav-link">
        <form>
            @include('marco.form.datebox',fData('desde',$desde,[],true,null,true,true))
            @include('marco.form.datebox',fData('hasta',$hasta,[],true,null,true,true))
            @include('marco.form.submit',fData('find'))
        </form>
        <div class="row">
            <div class="col-sm-6">
                <form method="post" action="{{route('reporte.logs')}}" target="_blank">
                    {{csrf_field()}}
                    @include('marco.form.hidden',fData('desde',$desde))
                    @include('marco.form.hidden',fData('hasta',$hasta))
                    @include('marco.form.hidden',fData('modo','PDF'))
                    <button type="submit" class="btn btn-secondary">PDF</button>
                </form>
            </div>
            <div class="col-sm-6">
                <form method="post" action="{{route('reporte.logs')}}" target="_blank">
                    {{csrf_field()}}
                    @include('marco.form.hidden',fData('desde',$desde))
                    @include('marco.form.hidden',fData('hasta',$hasta))
                    @include('marco.form.hidden',fData('modo','Excel'))
                    <button type="submit" class="btn btn-secondary">Excel</button>
                </form>
            </div>
        </div>
        </div>
    </div>
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-9">
            <h3 class="card-title">Log del Sistema</h3>
        </div>
        <div class="col-sm-3">
            <a href="{{route('inicio')}}" class="btn btn-success">Volver</a>
        </div>
    </div>
@endsection


@section('contenido')
    <ul class="list-group">
        <li class="list-group-item row">
            <table class="table">
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
        </li>
    </ul>
    <div class="div-center">
        {{$info->appends(Request::except('page'))->links(paginacion_BS4())}}
    </div>

@endsection