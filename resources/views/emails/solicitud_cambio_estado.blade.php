<p>Su solicitud {{$solicitud->id}} ha sido {{$solicitud->estado}}</p>
@if(!is_null($solicitud->rechazo))
    <p>Motivo: {{$solicitud->rechazo->motivo->full_name}}</p>
@endif

