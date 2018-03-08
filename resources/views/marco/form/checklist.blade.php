<div class="form-group">
    @if($enable)
    <label class="col-md-{{$minimo?'12':'4'}} form-control-label">{{trans('labels.'.$eLabel)}}</label>
    @endif
    <div class="col-md-{{$minimo?'12':'6'}} ">
        @foreach($groups as $group => $elementos)
            <div class="card ">
                @if($group!='')
                    <div class="card-header card-danger" id="{{$group}}">
                        <strong class="col-sm-6">{{$group}}</strong>
                        @if($enable)
                            <button type="button" class="btn btn-success btn-sm action1">Invertir</button>
                            <button type="button" class="btn btn-success btn-sm action2">Todo</button>
                            <button type="button" class="btn btn-success btn-sm action3">Ninguno</button>
                        @endif
                    </div>
                @endif
                <div class="card-block group-{{$group}}">
                    @foreach($elementos as $element)
                        <label class="checkbox-inline">
                            @php($check = false)
                            @if(isset($eVal))
                                @foreach($eVal as $sVal)
                                    @if($sVal->id == $element->id)
                                        @php($check = true)
                                    @endif
                                @endforeach
                            @endif

                            <input class="select-{{$group}}"
                                   type="checkbox"
                                   name="{{$eName.'_'.$element->id}}"
                                   value="{{$element->id}}" {{$check?'checked':''}}
                                    {{$enable?'':'disabled'}}>
                            {{$element->name}}
                        </label>
                    @endforeach
                </div>
            </div>
            <br>
        @endforeach
    </div>
</div>