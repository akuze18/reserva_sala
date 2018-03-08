@extends('marco.sistema2')

@section('titulo')
    Listado de Usuarios
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-9">
            <h3 class="card-title">Listado de Usuarios Inactivos</h3>
        </div>
        <div class="col-sm-3">
            @permission('list.user')
            <a href="{{route('usuario.list')}}" class="btn btn-sm btn-info">Volver</a>
            @endpermission
        </div>
    </div>
@endsection
@section('contenido')
    <ul class="list-group">
        @foreach($usuarios as $usuario)
            <li class="list-group-item row">
                <div class="col-sm-8">
                    {{''.$usuario->name}}
                </div>
                <div class="col-sm-4">
                    <!-- Botonera de opciones por elemento -->
                    @permission('create.user')
                    @if($usuario->id!=actualUser()->id)
                    <button type="button" data-toggle="modal" data-target="#modalborrar"
                            class="btn btn-sm btn-success derecha" id="{{$usuario->id}}">
                        Reactivar
                    </button>
                    @endif
                    @endpermission
                </div>
            </li>
        @endforeach
    </ul>
    <div class="div-center">
        {{$usuarios->links(paginacion_BS4())}}
    </div>
    @include('modals.confirma-eliminar',['ruta_destroy'=>'usuario.restore','mensaje_destroy'=>'Desea reactivar el usuario'])
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