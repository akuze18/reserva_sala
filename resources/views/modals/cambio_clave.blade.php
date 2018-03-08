<div class="modal fade" id="modalclave" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Cambiar Clave</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- formulario -->
            <form method="POST" action="{{route('cambio_pass',ActualUser()->id)}}">
                <div class="modal-body">
                    {{ csrf_field() }}
                    @include('marco.form.password',fData('password',null,[],true,8,false,true,4))
                    <p id="passwordHelpBlock" class="form-text text-muted ">
                        Tu Clave debe contener 8 caracteres.
                    </p>
                    @include('marco.form.password',fData('password_confirmation',null,[],true,8,false,true,4))

                </div>
                <div class="modal-footer">
                    <!-- <button type="button" id="btnLimpiar" class="btn btn-warning">Limpiar</button> -->
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>