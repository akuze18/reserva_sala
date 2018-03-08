<div class="form-group">
    @if(count($botones)==1)
        <div class="col-md-6 col-md-offset-4">
            @foreach($botones as $boton)
                <button type="{{$boton->tipo()}}" class="btn btn-{{$boton->color()}}" id="{{$boton->nombre()}}">
                    <i class="fa fa-btn {{$boton->icono()}}"></i> {{trans('labels.'.$boton->nombre())}}
                </button>
            @endforeach
        </div>
    @endif
    @if(count($botones)==2)
        <div class="col-md-6 col-md-offset-4">
            @foreach($botones as $boton)
                <button type="{{$boton->tipo()}}" class="btn btn-{{$boton->color()}}" id="{{$boton->nombre()}}">
                    <i class="fa fa-btn {{$boton->icono()}}"></i> {{trans('labels.'.$boton->nombre())}}
                </button>
            @endforeach
        </div>
    @endif
        @if(count($botones)==3)
            <div class="col-md-7 col-md-offset-3">
                @foreach($botones as $boton)
                    <button type="{{$boton->tipo()}}" class="btn btn-{{$boton->color()}}" id="{{$boton->nombre()}}">
                        <i class="fa fa-btn {{$boton->icono()}}"></i> {{trans('labels.'.$boton->nombre())}}
                    </button>
                @endforeach
            </div>
        @endif
</div>