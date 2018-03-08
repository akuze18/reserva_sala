@extends('marco.sistema2')

@section('titulo')
    Reporte de Carreras más Activas
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
                    <form method="post" action="{{route('reporte.carrera-top')}}" target="_blank">
                        {{csrf_field()}}
                        @include('marco.form.hidden',fData('desde',$desde))
                        @include('marco.form.hidden',fData('hasta',$hasta))
                        @include('marco.form.hidden',fData('modo','PDF'))
                        <button type="submit" class="btn btn-secondary">PDF</button>
                    </form>
                </div>
                <div class="col-sm-6">
                    <form method="post" action="{{route('reporte.carrera-top')}}" target="_blank">
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
            <h3 class="card-title">Reporte de Carreras más Activas</h3>
        </div>
        <div class="col-sm-3">
            <a href="{{route('inicio')}}" class="btn btn-success">Volver</a>
        </div>
    </div>
@endsection

@section('contenido')

            <ul class="list-group">
                @foreach($info as $carrera)
                    <li class="list-group-item row">
                        <div class="col-sm-8">
                            {{$carrera->name}}
                        </div>
                        <div class="col-sm-4">
                            {{'Cantidad de Solicitudes ' .$carrera->usos_count}}
                        </div>
                    </li>
                @endforeach
            </ul>

    <div class="div-center">
        {{$info->appends(Request::except('page'))->links(paginacion_BS4())}}
    </div>
@endsection
