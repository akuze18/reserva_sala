<div class="form-group{{ $errors->has($eName) ? ' has-danger' : '' }} row">
    <label class="col-md-{{$minimo?'12':'4'}} form-control-label">{{ ucwords(trans('labels.'.$eLabel))}}</label>
    <div class="col-md-{{$minimo?'12':'6'}}">
        <input type="number" class="form-control" name="{{$eName}}"
                {{($enable)?'':'disabled'}} {{isset($len)?'max='.$len.'':''}}
                min=1 step=1
               value="{{isset($eVal)?$eVal:old($eName)}}">

        @if ($errors->has($eName))
            <span class="form-control-feedback">
                <strong>{{ $errors->first($eName) }}</strong>
            </span>
        @endif
    </div>
</div>