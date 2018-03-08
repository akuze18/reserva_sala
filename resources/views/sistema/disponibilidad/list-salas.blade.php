@extends('marco.sistema2')

@section('titulo')
    Consulta Disponibilidades
@endsection

@section('titulo_contenido')
    @foreach($edificios as $edificio)
        <div class="card-header row skeched ">
            <h3 class="card-title col-sm-7">Disponibilidad en Edificio {{$edificio->name}}</h3>
            <span>{{$edificios->links(paginacion_BS4())}}</span>
        </div>
    @endforeach
@endsection

@section('contenido')
    @foreach($edificios as $edificio)
    <div class="card-header row skeched ">
        <div class="card-title col-sm-4">&nbsp;</div>
        <div class="card-title col-sm-2">Edificio {{$edificio->name}}</div>
        @permission('edit.disponible')
        <div class="card-title col-sm-3">
            <form method="post" action="{{route('disponibilidad.update')}}">
                {{csrf_field()}}
                @include('marco.form.hidden',fData('envio','edificio'))
                @include('marco.form.hidden',fData('edificio_id',$edificio->id))
                @include('marco.form.hidden',fData('estado','Disponible'))
                <button type="submit" class="btn btn-sm btn-success col-sm-10">
                    Habilitar
                </button>
            </form>
            <form method="post" action="{{route('disponibilidad.update')}}">
                {{csrf_field()}}
                @include('marco.form.hidden',fData('envio','edificio'))
                @include('marco.form.hidden',fData('edificio_id',$edificio->id))
                @include('marco.form.hidden',fData('estado','Deshabilitado'))
                <button type="submit" class="btn btn-sm btn-danger col-sm-10">
                    Deshabilitar
                </button>
            </form>
        </div>
        @endpermission

    </div>
    <div class="card-body">
        <ul class="list-group">
            <li class="list-group-item row skeched">
                <table class="table table-bordered">
                    <tbody>
                        @foreach($edificio->pisos as $piso)
                        <tr>
                            <th class="text-center">
                                <p>Piso {{$piso->name}}</p>
                                @permission('edit.disponible')
                                <form method="post" action="{{route('disponibilidad.update')}}">
                                    {{csrf_field()}}
                                    @include('marco.form.hidden',fData('envio','piso'))
                                    @include('marco.form.hidden',fData('piso_id',$piso->id))
                                    @include('marco.form.hidden',fData('estado','Disponible'))
                                    <button type="submit" class="btn btn-sm btn-success col-sm-10">
                                        Habilitar
                                    </button>
                                </form>
                                <form method="post" action="{{route('disponibilidad.update')}}">
                                    {{csrf_field()}}
                                    @include('marco.form.hidden',fData('envio','piso'))
                                    @include('marco.form.hidden',fData('piso_id',$piso->id))
                                    @include('marco.form.hidden',fData('estado','Deshabilitado'))
                                    <button type="submit" class="btn btn-sm btn-danger col-sm-10">
                                        Deshabilitar
                                    </button>
                                </form>
                                @endpermission
                            </th>
                            @foreach($piso->salas as $sala)
                                <td class="text-center">
                                    <a class="btn btn-secondary  col-sm-9" href="{{route('disponibilidad.list-salas2',$sala->id)}}">
                                        Sala {{$sala->name}}
                                    </a>
                                    <p></p>
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
                                </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </li>
        </ul>
    </div>
    @endforeach
@endsection
