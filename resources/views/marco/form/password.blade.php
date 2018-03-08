<div class="form-group{{ $errors->has($eName) ? ' has-danger' : '' }}">
    <label class="col-md-{{$minimo?'12':'4'}} form-control-label">{{ ucwords(trans('labels.'.$eLabel))}}</label>
    <div class="col-md-{{$minimo?'12':'6'}}">
        <input type="password" class="form-control" name="{{$eName}}" id="{{$eName}}"
               {{($enable)?'':'disabled'}} {{isset($len)?'maxlength='.$len.'':''}} {{($len_min)?'minlength='.$len_min.'':''}}
               value="{{isset($eVal)?$eVal:old($eName)}}">

        @if ($errors->has($eName))
            <span class="form-control-feedback">
                <strong>{{ $errors->first($eName) }}</strong>
            </span>
        @endif
    </div>
</div>