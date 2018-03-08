@extends('marco.sistema2')

@section('titulo')
    Consulta Disponibilidades
@endsection

@section('titulo_contenido')
    <div class="card-header row skeched ">
        <h3 class="card-title">Disponibilidad por Sala</h3>
    </div>
@endsection

@section('contenido')
    <ul class="list-group">
        <li class="list-group-item">
            <div class="row">
            <div class="col-sm-3">
                <a class="btn btn-primary verPrimera" href="{{route('disponibilidad.list',['edificio'=>$sala->piso->edificio->id])}}">▲</a>
            </div>
            <div class="alert alert-success col-sm-4 text-center">
                {{'Sala '.$sala->name.' - Edificio '.$sala->piso->edificio->name}}
            </div>
            <div class="col-sm-2">
                @permission('edit.disponible')
                <form method="post" action="{{route('disponibilidad.update')}}">
                    {{csrf_field()}}
                    @include('marco.form.hidden',fData('envio','sala'))
                    @include('marco.form.hidden',fData('sala_id',$sala->id))
                    @include('marco.form.hidden',fData('estado','Disponible'))
                    <button type="submit" class="btn btn-sm btn-outline-success col-sm-12">
                        Habilitar
                    </button>
                </form>
                <form method="post" action="{{route('disponibilidad.update')}}">
                    {{csrf_field()}}
                    @include('marco.form.hidden',fData('envio','sala'))
                    @include('marco.form.hidden',fData('sala_id',$sala->id))
                    @include('marco.form.hidden',fData('estado','Deshabilitado'))
                    <button type="submit" class="btn btn-sm btn-outline-danger col-sm-12">
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
                <thead>
                <th class="text-center"><p>Modulo</p></th>
                @foreach($dias as $dia)
                    <th class="text-center">
                        {{$dia->name}}
                        @permission('edit.disponible')
                        <form method="post" action="{{route('disponibilidad.update')}}">
                            {{csrf_field()}}
                            @include('marco.form.hidden',fData('envio','sala-dia'))
                            @include('marco.form.hidden',fData('dia_id',$dia->id))
                            @include('marco.form.hidden',fData('sala_id',$sala->id))
                            @include('marco.form.hidden',fData('estado','Disponible'))
                            <button type="submit" class="btn btn-sm btn-outline-success col-sm-12">
                                Habilitar
                            </button>
                        </form>
                        <form method="post" action="{{route('disponibilidad.update')}}">
                            {{csrf_field()}}
                            @include('marco.form.hidden',fData('envio','sala-dia'))
                            @include('marco.form.hidden',fData('dia_id',$dia->id))
                            @include('marco.form.hidden',fData('sala_id',$sala->id))
                            @include('marco.form.hidden',fData('estado','Deshabilitado'))
                            <button type="submit" class="btn btn-sm btn-outline-danger col-sm-12">
                                Deshabilitar
                            </button>
                        </form>
                        @endpermission
                    </th>
                @endforeach
                </thead>
                <tbody>
                @foreach($modulos as $modulo)
                    <tr>
                        <th>
                            {{$modulo->full_name}}<br>
                            @permission('edit.disponible')
                            <form method="post" action="{{route('disponibilidad.update')}}">
                                {{csrf_field()}}
                                @include('marco.form.hidden',fData('envio','sala-modulo'))
                                @include('marco.form.hidden',fData('modulo_id',$modulo->id))
                                @include('marco.form.hidden',fData('sala_id',$sala->id))
                                @include('marco.form.hidden',fData('estado','Disponible'))
                                <button type="submit" class="btn btn-sm btn-outline-success col-sm-12">
                                    Habilitar
                                </button>
                            </form>
                            <form method="post" action="{{route('disponibilidad.update')}}">
                                {{csrf_field()}}
                                @include('marco.form.hidden',fData('envio','sala-modulo'))
                                @include('marco.form.hidden',fData('modulo_id',$modulo->id))
                                @include('marco.form.hidden',fData('sala_id',$sala->id))
                                @include('marco.form.hidden',fData('estado','Deshabilitado'))
                                <button type="submit" class="btn btn-sm btn-outline-danger col-sm-12">
                                    Deshabilitar
                                </button>
                            </form>
                            @endpermission
                        </th>
                        @foreach($dias as $dia)
                            @php($this_horario = $horarios->where('modulo_id',$modulo->id)
                            ->where('dia_id',$dia->id)
                            ->first())
                            @php($this_disponibilidad = $disponibilidades->where('horario_id',$this_horario->id)->first())
                            @if(is_null($this_disponibilidad))
                                <td class="text-center table-none">
                                    <p>Deshabilitado</p>
                                    @permission('edit.disponible')
                                    <form method="post" action="{{route('disponibilidad.update')}}">
                                        {{csrf_field()}}
                                        @include('marco.form.hidden',fData('envio','single'))
                                        @include('marco.form.hidden',fData('horario_id',$this_horario->id))
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
                                @if(!is_null($tomado))
                                    {!!$tomado->info()!!}
                                @else
                                    <p>{{$this_disponibilidad->estado}}</p>
                                    @permission('edit.disponible')
                                    <form method="post" action="{{route('disponibilidad.update')}}">
                                        {{csrf_field()}}
                                        @include('marco.form.hidden',fData('envio','single'))
                                        @include('marco.form.hidden',fData('horario_id',$this_horario->id))
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
            </table>
            </div>
        </li>
    </ul>
    @include('modals.disponibilidades')
@endsection
