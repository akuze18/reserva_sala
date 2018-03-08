<div class="modal fade" id="modalcambiar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Seguro que desea enviar Solicitud?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- formulario -->
                <form id="formcambiar" method="POST" action="{{route('solicitud.sala.store')}}">
                    @include('marco.form.select',fData('motivo',null,$motivos,true,null,true))
                    {{ csrf_field() }}
                    <div class="modal-body edit-content">
                        ...
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Enviar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-ban" aria-hidden="true"></i>&nbsp;Cancelar</button>
                    </div>
                </form>
                <!-- fin formulario -->
            </div>
        </div>
    </div>
</div>