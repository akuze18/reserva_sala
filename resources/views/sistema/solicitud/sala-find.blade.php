@extends('marco.sistema2')

@section('panelIzq')
    <div class="nav-item">
        <div class="nav-link">
        <form method="GET" action="{{route('solicitud.sala.find')}}" id="filtros">
            @include('marco.form.select',fData('modulo',$modulo,$modulos,true,null,true,false))
            @include('marco.form.select',fData('dia',$dia,$dias,true,null,true,false))
            @include('marco.form.select',fData('edificio',$edificio_id,$edificios,true,null,true,false))
            @include('marco.form.select',fData('piso',$piso_id,$pisos,true,null,true,false))
            @include('marco.form.select',fData('capacidad',$capacidad,$capacidades,true,null,true,false))
            <a href="{{route('solicitud.sala.find')}}" class="btn btn-danger"><i class="fa fa-btn fa-eraser"></i> Limpiar</a>
        </form>

        <span>No es necesario ocupar todos los filtros</span>

        </div>
    </div>
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-11">
            <h1 class="text-center"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;BUSQUEDA SALA</h1>
        </div>
        <div class="col-sm-1">
            <a href="{{route('inicio')}}" class="btn btn-success">Inicio</a>
        </div>
    </div>
@endsection

@section('contenido')
    <table class="table table-condensed table-responsive">
        <thead>
            <tr>
                <th>Edificio</th>
                <th>Piso</th>
                <th>Num. Sala</th>
                <th>Capacidad</th>
                <th>Dia</th>
                <th>Modulo</th>
                <th>Hora Inicio</th>
                <th>Hora Fin</th>
                <th>Agendar</th>
            </tr>
        </thead>
        <tbody class="">
        @if($disponiblidades->count()==0)
            <div class="alert-danger text-center"><p>NO SE HAN ENCONTRADO RESULTADOS</p></div>
        @else
            <div><p>RESULTADOS: {{$disponiblidades->firstItem()}}-{{$disponiblidades->lastItem()}} de {{$disponiblidades->total()}}</p></div>
        @endif
        @foreach($disponiblidades as $disponibilidad)
            <tr >
                <td>{{$disponibilidad->sala->piso->edificio->name}}</td>
                <td>{{$disponibilidad->sala->piso->name}}</td>
                <td>{{$disponibilidad->sala->name}}</td>
                <td>{{$disponibilidad->sala->capacidad}}</td>
                <td>{{$disponibilidad->horario->dia->name}}</td>
                <td>{{$disponibilidad->horario->modulo->name}}</td>
                <td>{{$disponibilidad->horario->modulo->hora_inicio_f}}</td>
                <td>{{$disponibilidad->horario->modulo->hora_fin_f}}</td>

                <td class="table-{{estado_aprov_color($disponibilidad->estado,$disponibilidad->tomado_actual())}}">

                        @permission('create.solicitud')
                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalcambiar"
                                id="{{$disponibilidad->id}}">
                            <i class="fa fa-pencil-square-o"></i>&nbsp;Solicitar
                        </button>
                        @endpermission

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="div-center">{{$disponiblidades->appends(Request::except('page'))->links(paginacion_BS4())}}</div>

@include('modals.enviar_solicitud')
@endsection

@section('panelDer')
    <div style="height: 35%">&nbsp</div>
    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalinfo">
        Explicacion
    </button>
    @include('modals.disponibilidades')
@endsection

@section('otros_js')
    <script language="javascript">
        $(document).ready(function(){
            $('#modalcambiar').on('show.bs.modal', function(e) {
                var $modal = $(this),
                        esseyId = e.relatedTarget.id;
                $modal.find('.edit-content').html('<input type="hidden" name="disponible_id" value="'+esseyId+'">');
            });
            $('#filtros').change(function(){
                $(this).submit();
            });
        });
    </script>
@endsection