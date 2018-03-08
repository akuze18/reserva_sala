<!-- Modal Cambiar Estado-->
<div class="modal fade" id="modalrechazar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalTitle">Cambiar Estado Solicitud</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- formulario -->
                <form id="formcambiar" method="post" action="{{route('solicitud.store')}}">
                    <div class="modal-body">Confirma rechazar la solicitud</div>
                    {{ csrf_field() }}
                    @include('marco.form.select',fData('motivo',null,$motivos))
                    <div class="modal-body edit-content">
                        ...
                    </div>

                    <input type="hidden" name="accion" class="accion" value="Rechazada">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Si</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                    </div>
                </form>
                <!-- fin formulario -->
            </div>
        </div>
    </div>
</div>
<!-- fin modal Cambiar Estado-->