@extends('marco.sistema2')

@section('titulo')
    Listado de Mi Carga Academica
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-11">
            <h3 class="card-title">Listado de Mi Carga Academica</h3>
        </div>
        <div class="col-sm-1">
            <a href="{{route('inicio')}}" class="btn btn-success">Inicio</a>
        </div>
    </div>
@endsection

@section('contenido')
    <div>
        <p>{{'Docente : '.$docente->name}}</p>
        <p>{{'Carrera : '.$docente->carrera->name}}</p>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Modulo</th>
                @foreach($dias as $dia)
                    <th class="text-center">{{$dia->full_name}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($modulos as $modulo)
            <tr>
                <td><span class="badge badge-default">{{$modulo->name}}</span><br>{{$modulo->hora_inicio_f}}<br>{{$modulo->hora_fin_f}}</td>
                @foreach($dias as $dia)
                <td class="">
                    <div>
                        @php($carga_academica = $asignacion[$dia->id][$modulo->id][1])
                        @php($horario = $asignacion[$dia->id][$modulo->id][0])
                        @if(is_null($carga_academica))
                            <br>
                            <div class="text-center">Disponible</div>
                        @else
                            <div class="text-center">
                                Sala: {{$carga_academica->sala->name}}<br>
                                Edificio: {{$carga_academica->sala->piso->edificio->name}}<br>
                                Asignatura : {{$carga_academica->asignatura->name}}
                            </div>
                        @endif
                    </div>
                </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection