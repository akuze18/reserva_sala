@extends('marco.sistema2')

@section('titulo')
    Listado de Pisos
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-10">
            <h3 class="card-title">Listado de Pisos</h3>
        </div>
        @permission('create.piso')
        <div class="col-sm-2">
            <a href="{{route('piso.create')}}" class="btn btn-success">Nuevo Piso</a>
        </div>
        @endpermission
    </div>
@endsection

@section('contenido')
    <ul class="list-group">
        @foreach($pisos as $piso)
            <li class="list-group-item">
                <div class="row">
                <div class="col-sm-8">
                    {{'Piso '.$piso->name.' > Edificio '.$piso->edificio->name}}
                </div>
                <div class="col-sm-4">
                    <!-- Botonera de opciones por elemento -->
                    @permission('delete.piso')
                    <button type="button" data-toggle="modal" data-target="#modalborrar"
                            class="btn btn-sm btn-danger derecha" id="{{$piso->id}}">
                        Eliminar
                    </button>
                    @endpermission
                    @permission('edit.piso')
                    <a href="{{route('piso.edit',$piso->id)}}" class="btn btn-sm btn-warning derecha">Modificar</a>
                    @endpermission
                    @permission('see.piso')
                    <a href="{{route('piso.show',$piso->id)}}" class="btn btn-sm btn-primary derecha">Detalle</a>
                    @endpermission
                </div>
                </div>
            </li>
        @endforeach
    </ul>
    <div class="div-center">
        {{$pisos->links(paginacion_BS4())}}
    </div>
    @include('modals.eliminar-piso  ')
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