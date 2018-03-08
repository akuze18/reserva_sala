@extends('marco.sistema2')

@section('titulo')
    Listado de Usuarios
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-9">
            <h3 class="card-title">Listado de Usuarios</h3>
        </div>
        <div class="col-sm-3">
            @permission('create.user')
            <a href="{{route('usuario.create')}}" class="btn btn-success">Nuevo Usuario</a>
            @endpermission
        </div>
    </div>
@endsection

@section('contenido')

    <div class="card-header row">
        <a class="btn {{($perfil==''?'btn-primary':'btn-outline-primary')}}
            btn-sm col-sm-{{12-(round(12/($roles->count()+1),0)*$roles->count())}}"
           href="{{route('usuario.list')}}">
            Todos
        </a>
        @foreach($roles as $rol)
            <a class="btn {{($perfil==$rol->slug?'btn-primary':'btn-outline-primary')}}
            btn-sm col-sm-{{round(12/($roles->count()+1),0)}}"
               href="{{route('usuario.list',['perfil'=>$rol->slug])}}">
                {{$rol->name}}
            </a>
        @endforeach
    </div>

    <ul class="list-group">
        @foreach($usuarios as $usuario)
            <li class="list-group-item">
                <div class="row">
                <div class="col-sm-7">
                    {{''.$usuario->name}}
                </div>
                <div class="col-sm-5">
                    <!-- Botonera de opciones por elemento -->
                    @permission('disable.user')
                        @if($usuario->id!=actualUser()->id)
                        <button type="button" data-toggle="modal" data-target="#modalborrar"
                                class="btn btn-sm btn-danger derecha" id="{{$usuario->id}}">
                            Inactivar
                        </button>
                        @else
                        <button type="button" class="btn btn-sm btn-disabled derecha">
                            Inactivar
                        </button>
                        @endif
                    @endpermission
                    @permission('edit.user')
                    <a href="{{route('usuario.edit',$usuario->id)}}" class="btn btn-sm btn-warning derecha">Modificar</a>
                    @endpermission
                    @permission('see.user')
                    <a href="{{route('usuario.show',$usuario->id)}}" class="btn btn-sm btn-info derecha">Detalle</a>
                    @endpermission
                </div>
                </div>
            </li>
        @endforeach
    </ul>

    <div class="div-center">
        {{$usuarios->links(paginacion_BS4())}}
    </div>
    @permission('list.user')
    <a href="{{route('usuario.list-inactive')}}" class="btn btn-secondary">Usuarios Inactivos</a>
    @endpermission
    @include('modals.confirma-eliminar',['ruta_destroy'=>'usuario.destroy','mensaje_destroy'=>'Desea desactivar el usuario'])
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