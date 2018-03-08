@extends('marco.sistema2')

@section('titulo')
    Consulta Disponibilidades por Horario
@endsection

@section('titulo_contenido')
    <div class="row skeched ">
        <h3 class="card-title">Disponibilidad en Horario</h3>
    </div>
@endsection

@section('contenido')
    <ul class="list-group">
        <li class="list-group-item row">
            <table class="table table-bordered primera">
                <thead>
                <th class="text-center"><p>Modulo</p></th>
                @foreach($dias as $dia)
                    <th class="text-center">
                        {{$dia->name}}
                        @permission('edit.disponible')
                        <form method="post" action="{{route('disponibilidad.update')}}">
                            {{csrf_field()}}
                            @include('marco.form.hidden',fData('envio','dia'))
                            @include('marco.form.hidden',fData('dia_id',$dia->id))
                            @include('marco.form.hidden',fData('estado','Disponible'))
                            <button type="submit" class="btn btn-sm btn-outline-success col-sm-12">
                                Habilitar
                            </button>
                        </form>
                        <form method="post" action="{{route('disponibilidad.update')}}">
                            {{csrf_field()}}
                            @include('marco.form.hidden',fData('envio','dia'))
                            @include('marco.form.hidden',fData('dia_id',$dia->id))
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
                    <th class="text-center">
                        {{$modulo->full_name}}<br>
                        @permission('edit.disponible')
                        <form method="post" action="{{route('disponibilidad.update')}}">
                            {{csrf_field()}}
                            @include('marco.form.hidden',fData('envio','modulo'))
                            @include('marco.form.hidden',fData('modulo_id',$modulo->id))
                            @include('marco.form.hidden',fData('estado','Disponible'))
                            <button type="submit" class="btn btn-sm btn-outline-success col-sm-8">
                                Habilitar
                            </button>
                        </form>
                        <form method="post" action="{{route('disponibilidad.update')}}">
                            {{csrf_field()}}
                            @include('marco.form.hidden',fData('envio','modulo'))
                            @include('marco.form.hidden',fData('modulo_id',$modulo->id))
                            @include('marco.form.hidden',fData('estado','Deshabilitado'))
                            <button type="submit" class="btn btn-sm btn-outline-danger col-sm-8">
                                Deshabilitar
                            </button>
                        </form>
                        @endpermission
                    </th>
                    @foreach($dias as $dia)
                    @php($this_horario = $horarios->where('modulo_id',$modulo->id)
                    ->where('dia_id',$dia->id)
                    ->first())
                    <td class="text-center">
                        <p>
                            <a class="btn btn-sm btn-secondary" href="{{route('disponibilidad.list-horario2',$this_horario->id)}}">Revisar</a>
                        </p>
                        @permission('edit.disponible')
                        <form method="post" action="{{route('disponibilidad.update')}}">
                            {{csrf_field()}}
                            @include('marco.form.hidden',fData('envio','horario'))
                            @include('marco.form.hidden',fData('horario_id',$this_horario->id))
                            @include('marco.form.hidden',fData('estado','Disponible'))
                            <button type="submit" class="btn btn-sm btn-success col-sm-10">
                                Habilitar
                            </button>
                        </form>
                        <form method="post" action="{{route('disponibilidad.update')}}">
                            {{csrf_field()}}
                            @include('marco.form.hidden',fData('envio','horario'))
                            @include('marco.form.hidden',fData('horario_id',$this_horario->id))
                            @include('marco.form.hidden',fData('estado','Deshabilitado'))
                            <button type="submit" class="btn btn-sm btn-danger col-sm-10">
                                Deshabilitar
                            </button>
                        </form>
                        @endpermission
                    </td>
                    @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>

        </li>
    </ul>
@endsection