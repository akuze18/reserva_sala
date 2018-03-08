<div class="form-group{{ $errors->has($eName) ? ' has-danger' : '' }}">
    <label class="col-md-{{$minimo?'12':'4'}} form-control-label">{{ ucwords(trans('labels.'.$eLabel))}}</label>
    <div class="col-md-{{$minimo?'12':'6'}}">
        <textarea class="form-control" rows="5" name="{{$eName}}" {{($enable)?'':'disabled'}} {{isset($len)?'maxlength='.$len.'':''}}>{{isset($eVal)?$eVal:old($eName)}}</textarea>
        @if ($errors->has($eName))
            <span class="form-control-feedback">
                <strong>{{ $errors->first($eName) }}</strong>
            </span>
        @endif
    </div>
</div>