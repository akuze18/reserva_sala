@extends('marco.sistema2')

@section('titulo')
    Lista de mis solicitudes
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-11">
            <h1 class="text-center"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;MIS SOLICITUDES</h1>
        </div>
        <div class="col-sm-1">
            <a href="{{route('inicio')}}" class="btn btn-success">Inicio</a>
        </div>
    </div>
@endsection

@section('contenido')
    <div class="col-md-12 div-center">
        <i class="fa fa-filter fa-2x" aria-hidden="true"></i>&nbsp;
        <a href="{{route('miSolicitud.index')}}" class="btn btn{{$estado==''?'':'-outline'}}-primary"><i class="fa fa-globe" aria-hidden="true"></i>&nbsp;Todas</a>
        <a href="{{route('miSolicitud.index','Pendiente')}}" class="btn btn{{$estado=='Pendiente'?'':'-outline'}}-warning"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;Pendientes</a>
        <a href="{{route('miSolicitud.index','Aceptada')}}" class="btn btn{{$estado=='Aceptada'?'':'-outline'}}-success"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Aceptadas</a>
        <a href="{{route('miSolicitud.index','Rechazada')}}" class="btn btn{{$estado=='Rechazada'?'':'-outline'}}-danger"><i class="fa fa-ban" aria-hidden="true"></i>&nbsp;Rechazadas</a>
    </div>

    <table class="table">
        <thead>
            <tr class="">
                <th class="row">
                    <div class="col-sm-6 text-center">
                        <i class="fa fa-graduation-cap" aria-hidden="true"></i>&nbsp;Datos Solicitud
                    </div>
                    <div class="col-sm-4 text-center">
                        <i class="fa fa-building-o" aria-hidden="true"></i>&nbsp;Datos de Sala
                    </div>
                </th>
            </tr>
            <tr>
                <th class="row">
                    <div class="col-sm-1">Nº Solicitud</div>
                    <div class="col-sm-2">Fecha Solicitud</div>
                    <div class="col-sm-3">Motivo</div>
                    <div class="col-sm-1">Edificio</div>
                    <div class="col-sm-1">Nº Sala</div>
                    <div class="col-sm-1">Modulo</div>
                    <div class="col-sm-1">Dia</div>
                    <div class="col-sm-1">Estado Solicitud</div>
                </th>
            </tr>
        </thead>
        <tbody>
        @foreach($solicitudes as $solicitud)
            <tr class="table-@if($solicitud->estado == 'Aceptada')success @elseif($solicitud->estado == 'Rechazada')danger @elseif($solicitud->estado == 'Pendiente')warning @endif">
                <td class="row">
                    <div class="col-sm-1">{{$solicitud->id}}</div>
                    <div class="col-sm-2">{{$solicitud->fecha}}</div>
                    <div class="col-sm-3">{{$solicitud->motivo->descripcion}}</div>
                    <div class="col-sm-1">{{$solicitud->sala->piso->edificio->name}}</div>
                    <div class="col-sm-1">{{$solicitud->sala->name}}</div>
                    <div class="col-sm-1">{{$solicitud->horario->modulo->name}}</div>
                    <div class="col-sm-1">{{$solicitud->horario->dia->name}}</div>
                    <div class="col-sm-2">{{$solicitud->estado}}
                        @if($solicitud->estado =='Rechazada')
                            @permission('see.misolicitud')
                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalinfo" datasrc="{{$solicitud->rechazo->motivo->descripcion}}">
                                <i class="fa fa-info" aria-hidden="true"></i>
                            </button>
                            @endpermission
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="div-center">{{$solicitudes->links(paginacion_BS4())}} </div>
    @include('modals.informacion',['titulo'=>'Motivo de Rechazo'])
@endsection

@section('otros_js')
    <script type="text/javascript">
        $('#modalinfo').on('show.bs.modal', function(e) {
            var $modal = $(this);
            var atributo = (e.relatedTarget.getAttribute('datasrc'));
            $modal.find('.edit-content').html(atributo);
        });
    </script>
@endsection