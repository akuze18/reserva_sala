@extends('marco.sistema2')

@section('titulo')
    Listado de Salas
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-10">
            <h3 class="card-title">Listado de Salas</h3>
        </div>
        @permission('create.sala')
        <div class="col-sm-2">
            <a href="{{route('sala.create')}}" class="btn btn-success">Nueva Sala</a>
        </div>
        @endpermission
    </div>
@endsection

@section('contenido')
    <ul class="list-group">
        @foreach($salas as $sala)
            <li class="list-group-item">
                <div class="row">
                <div class="col-sm-8">
                    {{'Sala '.$sala->name.' > Piso '.$sala->piso->name.' > Edificio '.$sala->piso->edificio->name}}
                </div>
                <div class="col-sm-4">
                    <!-- Botonera de opciones por elemento -->
                    @permission('delete.sala')
                    <button type="button" data-toggle="modal" data-target="#modalborrar"
                            class="btn btn-sm btn-danger derecha" id="{{$sala->id}}">
                        Eliminar
                    </button>
                    @endpermission
                    @permission('edit.sala')
                    <a href="{{route('sala.edit',$sala->id)}}" class="btn btn-sm btn-warning derecha">Modificar</a>
                    @endpermission
                    @permission('see.sala')
                    <a href="{{route('sala.show',$sala->id)}}" class="btn btn-sm btn-info derecha">Ver</a>
                    @endpermission
                </div>
                </div>
            </li>
        @endforeach
    </ul>
    <div class="div-center">
        {{$salas->links(paginacion_BS4())}}
    </div>
    @include('modals.eliminar-sala')
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