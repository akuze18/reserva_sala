@extends('marco.sistema2')

@section('titulo')
    Listado de Carga Academica Docente {{$docente->name}}
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-12">
            <h3 class="card-title">Listado de Carga Academica: {{$docente->name}}</h3>
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
                            @permission('create.cargaacademica')
                            <div class="parent-center">
                                <a href="{{route('CA.create',[$docente->id,$horario->id])}}" class="btn btn-sm btn-success content-center"><i class="fa fa-check fa-fw"></i></a>
                            </div>
                            @endpermission
                        @else
                            <div class="text-center">
                                Sala: {{$carga_academica->sala->name}}<br>
                                Edificio: {{$carga_academica->sala->piso->edificio->name}}<br>
                                Asignatura : {{$carga_academica->asignatura->name}}
                            </div>
                            <!-- Botonera de opciones por elemento -->
                            <div class="parent-center">
                                <div class="content-center">
                                    @permission('edit.cargaacademica')
                                    <a href="{{route('CA.edit',$carga_academica->id)}}" class="btn btn-sm btn-warning"><i class="fa fa-pencil-square-o fa-fw"></i></a>
                                    @endpermission
                                    @permission('delete.cargaacademica')
                                    <button type="button" data-toggle="modal" data-target="#modalborrar"
                                            class="btn btn-sm btn-danger" id="{{$carga_academica->id}}">
                                        <i class="fa fa-ban fa-fw"></i>
                                    </button>
                                    @endpermission
                                </div>
                            </div>
                        @endif
                    </div>
                </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
    @include('modals.confirma-eliminar',['ruta_destroy'=>'CA.destroy','mensaje_destroy'=>' Desea eliminar Carga Academica   '])
@endsection

@section('otros_js')
    <script language="javascript">
        $('#modalborrar').on('show.bs.modal', function(e) {
            var $modal = $(this),
                    esseyId = e.relatedTarget.id;
            var $formulario = $modal.find('.form-elimina');
            var $baseAction = $formulario[0].getAttribute('action');
            var $newAction = $baseAction.replace('_ID_',esseyId);
            $formulario[0].setAttribute('action',$newAction);
        });
    </script>
@endsection