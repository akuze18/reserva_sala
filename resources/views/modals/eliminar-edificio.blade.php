<div class="modal fade" id="modalborrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Confirmación de Eliminar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- formulario -->
            <form class="form-elimina" method="POST" action="{{route('edificio.destroy','_ID_')}}">
                <div class="modal-body">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}
                    Desea eliminar edificio
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Si</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                </div>
            </form>
            <!-- fin formulario -->
        </div>
    </div>
</div>