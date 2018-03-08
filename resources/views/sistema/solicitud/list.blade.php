@extends('marco.sistema2')

@section('titulo')
    Control de Solicitudes
@endsection
@section('titulo_contenido')
    <h1 class="text-center">
        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;SOLICITUDES
    </h1>
@endsection

@section('contenido')
    <div class="col-md-12 div-center">
        <i class="fa fa-filter fa-2x" aria-hidden="true"></i>&nbsp;
        <a href="{{route('solicitud.index')}}" class="btn btn{{$estado==''?'':'-outline'}}-primary"><i class="fa fa-globe" aria-hidden="true"></i>&nbsp;Todas</a>
        <a href="{{route('solicitud.index','Pendiente')}}" class="btn btn{{$estado=='Pendiente'?'':'-outline'}}-warning"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;Pendientes</a>
        <a href="{{route('solicitud.index','Aceptada')}}" class="btn btn{{$estado=='Aceptada'?'':'-outline'}}-success"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Aceptadas</a>
        <a href="{{route('solicitud.index','Rechazada')}}" class="btn btn{{$estado=='Rechazada'?'':'-outline'}}-danger"><i class="fa fa-ban" aria-hidden="true"></i>&nbsp;Rechazadas</a>
    </div>

    <table class="table table-striped table-responsive">
        <thead>
        <tr>
            <th class="text-center" colspan="5" ><i class="fa fa-graduation-cap" aria-hidden="true"></i>&nbsp;Datos Solicitante</th>
            <th class="text-center" colspan="5"><i class="fa fa-building-o" aria-hidden="true"></i>&nbsp;Datos de Sala</th>
        </tr>
        <tr>
            <th>Nº Solicitud</th>
            <th>Rut Solicitante</th>
            <th>Nombre Solicitante</th>
            <th>Fecha Solicitud</th>
            <th>Motivo Solicitud</th>
            <th>Edificio</th>
            <th>Nº Sala</th>
            <th>Modulo</th>
            <th>Dia</th>
            <th>Estado Solicitud</th>
            @role('admin')
            <th>Cambiar Estado</th>
            @endrole
        </tr>
        </thead>
        <tbody>
        @foreach($solicitudes as $solicitud)
        <tr class="table-@if($solicitud->estado == 'Aceptada')success @elseif($solicitud->estado == 'Rechazada')danger @elseif($solicitud->estado == 'Pendiente')warning @endif">
            <th scope="row">{{$solicitud->id}}</th>
            <td>{{$solicitud->user->rut}}</td>
            <td>{{$solicitud->user->name}}</td>
            <td>{{$solicitud->fecha}}</td>
            <td>{{$solicitud->motivo->descripcion}}</td>
            <td>{{$solicitud->sala->piso->edificio->name}}</td>
            <td>{{$solicitud->sala->name}}</td>
            <td>{{$solicitud->horario->modulo->name}}</td>
            <td>{{$solicitud->horario->dia->name}}</td>
            <td>{{$solicitud->estado}}

            </td>
            @if($solicitud->estado =='Pendiente')
            <td>
                @permission('edit.solicitud')
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalaprobar" id="{{$solicitud->id}}"><i class="fa fa-check fa-fw"></i>&nbsp;Aprobar&nbsp;&nbsp;</button>
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalrechazar" id="{{$solicitud->id}}"><i class="fa fa-ban fa-fw"></i>&nbsp;Rechazar</button>
                @endpermission
            </td>
            @else
                <td>
                @if($solicitud->estado =='Rechazada')
                    @permission('see.solicitud')
                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalinfo" datasrc="{{$solicitud->rechazo->motivo->descripcion}}">
                        <i class="fa fa-info" aria-hidden="true"></i>
                    </button>
                    @endpermission
                @endif
                </td>
            @endif
        @endforeach
</tbody>
</table>
    <div class="div-center">
        {{$solicitudes->links(paginacion_BS4())}}
    </div>
    @include('modals.cambiar_estado_aceptar')
    @include('modals.cambiar_estado_rechazar')
    @include('modals.informacion',['titulo'=>'Motivo de Rechazo'])
@endsection

@section('otros_js')
<script>
    $('#modalrechazar').on('show.bs.modal', function(e) {
        var $modal = $(this),
                esseyId = e.relatedTarget.id;
        $modal.find('.edit-content').html('<input type="hidden" name="solicitud_id" value="'+esseyId+'">');
    });
    $('#modalaprobar').on('show.bs.modal', function(e) {
        var $modal = $(this),
                esseyId = e.relatedTarget.id;
        $modal.find('.edit-content').html('<input type="hidden" name="solicitud_id" value="'+esseyId+'">');
    });
    $('#modalinfo').on('show.bs.modal', function(e) {
        var $modal = $(this);
        var atributo = (e.relatedTarget.getAttribute('datasrc'));
        $modal.find('.edit-content').html(atributo);
    });
</script>
@endsection