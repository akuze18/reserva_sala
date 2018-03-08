<div class="form-group{{ $errors->has($eName) ? ' has-danger' : '' }} row">
    <label class="col-md-{{$minimo?'12':'4'}} form-control-label">{{trans('labels.'.$eLabel)}}</label>
    <div class="col-md-{{$minimo?'12':'6'}}">

        <select class="form-control" name="{{$eName}}" id="{{$eName}}" {{$enable?'':'disabled'}}>
            @if(is_null($eVal) or !($requerido))<option selected {{$requerido?'disabled':'value='}}></option>@endif
            @foreach($elements as $element)

                @if($eVal==$element->id OR Request::old($eName) == $element->id)
                    <option value="{{$element->id}}" selected >{{$element->fullname}}</option>

                @else
                    <option value="{{$element->id}}" >{{$element->fullname}}</option>
                @endif

            @endforeach
        </select>
        @if ($errors->has($eName))
            <span class="form-control-feedback">
                <strong>{{ $errors->first($eName) }}</strong>
            </span>
        @endif
    </div>
</div>