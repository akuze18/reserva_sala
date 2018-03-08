@extends('marco.sistema2')

@section('titulo')
    Listado de Edificios
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-10">
            <h3 class="card-title">Listado de Edificios</h3>
        </div>
        @permission('create.edificio')
        <div class="col-sm-2">
            <a href="{{route('edificio.create')}}" class="btn btn-success">Nuevo Edificio</a>
        </div>
        @endpermission
    </div>
@endsection

@section('contenido')
    <ul class="list-group">
        @foreach($edificios as $edificio)
            <li class="list-group-item">
                <div class="row">
                <div class="col-sm-8">
                    {{'Edificio '.$edificio->name}}
                </div>
                <div class="col-sm-4">
                    <!-- Botonera de opciones por elemento -->
                    @permission('delete.edificio')
                    <button type="button" data-toggle="modal" data-target="#modalborrar"
                            class="btn btn-sm btn-danger derecha" id="{{$edificio->id}}">
                        Eliminar
                    </button>
                    @endpermission
                    @permission('edit.edificio')
                    <a href="{{route('edificio.edit',$edificio->id)}}" class="btn btn-sm btn-warning derecha">Modificar</a>
                    @endpermission
                    @permission('see.edificio')
                    <a href="{{route('edificio.show',$edificio->id)}}" class="btn btn-sm btn-primary derecha">Detalle</a>
                    @endpermission
                </div>
                </div>
            </li>
        @endforeach
    </ul>
    <div class="div-center">
        {{$edificios->links(paginacion_BS4())}}
    </div>
    @include('modals.eliminar-edificio')
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