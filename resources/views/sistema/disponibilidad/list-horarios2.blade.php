@extends('marco.sistema2')

@section('titulo')
    Consulta Disponibilidades por Horario
@endsection

@section('titulo_contenido')
    <div class="row skeched ">
        <h3 class="card-title">Disponibilidad por Horario</h3>
    </div>
@endsection

@section('contenido')
    <ul class="list-group">
        <li class="list-group-item">
            <div class="row">
            <div class="col-sm-3">
                <a class="btn btn-primary verPrimera" href="{{route('disponibilidad.list-horario')}}">▲</a>
            </div>
            <div class="alert alert-success col-sm-4 text-center">
                {{$horario->dia->name.' - Modulo '.$horario->modulo->name}}
            </div>
            <div class="col-sm-2">
                @permission('edit.disponible')
                <form method="post" action="{{route('disponibilidad.update')}}">
                    {{csrf_field()}}
                    @include('marco.form.hidden',fData('envio','horario'))
                    @include('marco.form.hidden',fData('horario_id',$horario->id))
                    @include('marco.form.hidden',fData('estado','Disponible'))
                    <button type="submit" class="btn btn-sm btn-outline-success col-sm-10">
                        Habilitar
                    </button>
                </form>
                <form method="post" action="{{route('disponibilidad.update')}}">
                    {{csrf_field()}}
                    @include('marco.form.hidden',fData('envio','horario'))
                    @include('marco.form.hidden',fData('horario_id',$horario->id))
                    @include('marco.form.hidden',fData('estado','Deshabilitado'))
                    <button type="submit" class="btn btn-sm btn-outline-danger col-sm-10">
                        Deshabilitar
                    </button>
                </form>
                @endpermission
            </div>
            <div class="col-sm-3">
                <button class="btn btn-primary derecha" type="button" data-toggle="modal" data-target="#modalinfo">
                    Explicacion
                </button>
            </div>
            <table class="table table-bordered">
                @foreach($edificios as $edificio)
                <thead>
                    <tr>
                        <th colspan="{{($edificio->maxSalas()+1)}}" class="text-center ">
                            <div class="row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-2">Edificio {{$edificio->name}}</div>
                                <div class="col-sm-2">
                                    @permission('edit.disponible')
                                    <form method="post" action="{{route('disponibilidad.update')}}">
                                        {{csrf_field()}}
                                        @include('marco.form.hidden',fData('envio','horario-edificio'))
                                        @include('marco.form.hidden',fData('horario_id',$horario->id))
                                        @include('marco.form.hidden',fData('edificio_id',$edificio->id))
                                        @include('marco.form.hidden',fData('estado','Disponible'))
                                        <button type="submit" class="btn btn-sm btn-outline-success col-sm-10">
                                            Habilitar
                                        </button>
                                    </form>
                                    <form method="post" action="{{route('disponibilidad.update')}}">
                                        {{csrf_field()}}
                                        @include('marco.form.hidden',fData('envio','horario-edificio'))
                                        @include('marco.form.hidden',fData('horario_id',$horario->id))
                                        @include('marco.form.hidden',fData('edificio_id',$edificio->id))
                                        @include('marco.form.hidden',fData('estado','Deshabilitado'))
                                        <button type="submit" class="btn btn-sm btn-outline-danger col-sm-10">
                                            Deshabilitar
                                        </button>
                                    </form>
                                    @endpermission
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($edificio->pisos as $piso)
                    <tr>
                        <th class="text-center">
                            <p>Piso {{$piso->name}}</p>
                            @permission('edit.disponible')
                            <form method="post" action="{{route('disponibilidad.update')}}">
                                {{csrf_field()}}
                                @include('marco.form.hidden',fData('envio','horario-piso'))
                                @include('marco.form.hidden',fData('horario_id',$horario->id))
                                @include('marco.form.hidden',fData('piso_id',$piso->id))
                                @include('marco.form.hidden',fData('estado','Disponible'))
                                <button type="submit" class="btn btn-sm btn-outline-success col-sm-10">
                                    Habilitar
                                </button>
                            </form>
                            <form method="post" action="{{route('disponibilidad.update')}}">
                                {{csrf_field()}}
                                @include('marco.form.hidden',fData('envio','horario-piso'))
                                @include('marco.form.hidden',fData('horario_id',$horario->id))
                                @include('marco.form.hidden',fData('piso_id',$piso->id))
                                @include('marco.form.hidden',fData('estado','Deshabilitado'))
                                <button type="submit" class="btn btn-sm btn-outline-danger col-sm-10">
                                    Deshabilitar
                                </button>
                            </form>
                            @endpermission
                        </th>
                        @foreach($piso->salas as $sala)
                            @php($this_disponibilidad = $disponibilidades->where('sala_id',$sala->id)->first())
                            @if(is_null($this_disponibilidad))
                                <td class="text-center table-none">
                                    <strong>Sala {{$sala->name}}</strong>
                                    @permission('edit.disponible')
                                    <form method="post" action="{{route('disponibilidad.update')}}">
                                        {{csrf_field()}}
                                        @include('marco.form.hidden',fData('envio','single'))
                                        @include('marco.form.hidden',fData('horario_id',$horario->id))
                                        @include('marco.form.hidden',fData('sala_id',$sala->id))
                                        @include('marco.form.hidden',fData('estado','Disponible'))
                                        <button type="submit" class="btn btn-sm btn-secondary">
                                            Habilitar
                                        </button>
                                    </form>
                                    @endpermission
                                </td>
                            @else
                                @php($tomado = $this_disponibilidad->tomado_actual())
                                <td class="text-center table-{{estado_aprov_color($this_disponibilidad->estado,$tomado)}}">
                                <strong>Sala {{$sala->name}}</strong><br>
                                @if(!is_null($tomado))
                                    {!!$tomado->info()!!}
                                @else
                                    @permission('edit.disponible')
                                    <p></p>
                                    <form method="post" action="{{route('disponibilidad.update')}}">
                                        {{csrf_field()}}
                                        @include('marco.form.hidden',fData('envio','single'))
                                        @include('marco.form.hidden',fData('horario_id',$horario->id))
                                        @include('marco.form.hidden',fData('sala_id',$sala->id))
                                        @include('marco.form.hidden',fData('estado',($this_disponibilidad->estado=='Disponible'?'Deshabilitado':'Disponible')))
                                        <button type="submit" class="btn btn-sm btn-secondary">
                                            {{$this_disponibilidad->estado=='Disponible'?'Desabilitar':'Habilitar'}}
                                        </button>
                                    </form>
                                    @endpermission
                                @endif
                                </td>
                            @endif
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
                @endforeach
            </table>
            </div>
        </li>
        <li class="list-group-item row">
            <div class="col-sm-5"></div>
            <div>
            {{$edificios->links(paginacion_BS4())}}
            </div>
        </li>
    </ul>
    @include('modals.disponibilidades')
@endsection

