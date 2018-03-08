@extends('marco.sistema2')

@section('titulo')
    Listado de Motivos
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-9">
            <h4 class="card-title">Listado de Motivos</h4>
        </div>
        @permission('create.motivo')
        <div class="col-sm-3">
            <a href="{{route('motivo.create')}}" class="btn btn-success btn-sm">Nuevo Motivo</a>
        </div>
        @endpermission
    </div>
@endsection

@section('contenido')
    <ul class="list-group">
        @foreach($motivos as $motivo)
            <li class="list-group-item">
                <div class="row">
                <div class="col-sm-2">
                    <h4><span class="badge badge-info">{{$motivo->action_name}}</span></h4>
                </div>
                <div class="col-sm-7">
                    {{$motivo->descripcion}}
                </div>
                <div class="col-sm-3">
                    <!-- Botonera de opciones por elemento -->
                    @permission('edit.motivo')
                    <a href="{{route('motivo.edit',$motivo->id)}}" class="btn btn-sm btn-warning">Modificar</a>
                    @endpermission
                    @permission('delete.motivo')
                    <button type="button" data-toggle="modal" data-target="#modalborrar"
                            class="btn btn-sm btn-danger" id="{{$motivo->id}}">
                        Eliminar
                    </button>
                    @endpermission
                </div>
                </div>
            </li>
        @endforeach
    </ul>
    {{$motivos->links(paginacion_BS4())}}
    @include('modals.confirma-eliminar',['ruta_destroy'=>'motivo.destroy','mensaje_destroy'=>' Desea eliminar Motivo'])
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