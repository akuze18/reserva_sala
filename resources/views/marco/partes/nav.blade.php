<nav class="navbar navbar-inverse navbar-toggleable-sm sticky-top navigation" style="background-color: #9a0000 ;">
    <div class="col-sm-1">
        <a class="navbar-brand" href="{{route('inicio')}}">
            <!-- logo empresa -->
            <img src="{{ url('/sistema/img/logov.svg')}}" width="45" height="45" class="d-inline-block align-top" alt="Logo RTE">
            <!-- fin logo -->
        </a>
    </div>
    <!-- boton menu -->
    <button class="navbar-toggler navbar-toggler-right"
            type="button"
            data-toggle="collapse"
            data-target="#menuprincipal"
            aria-controls="menuprincipal" aria-expanded="false" aria-label="Toggle navigation">
        <!-- <span class="navbar-toggler-icon"></span> -->
        <i class="fa fa-bars fa-2x" aria-hidden="true"></i>
    </button>
    <!-- fin boton menu -->

    <div class="collapse navbar-collapse col-md-9" id="menuprincipal">
        <div class="navbar-nav mr-auto ml-auto text-center">

            <a class="nav-item nav-link active" href="{{route('ingreso_sistema')}}">
                <i class="fa fa-home fa-fw" aria-hidden="true"></i>&nbsp;MI PERFIL
            </a>
            <!-- submenu buscar-->
            @permission('find.docente|find.disponible')
            <div class="dropdown">
                <a class="nav-item nav-link dropdown-toggle" href="#" id="sub-buscar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-search" aria-hidden="true"></i>&nbsp;BUSCAR
                </a>
                <div class="dropdown-menu dropdown-menu-left" aria-labelledby="sub-buscar">
                    @permission('find.docente')
                    <a class="dropdown-item" href="{{route('CA.search')}}">
                        <i class="fa fa-building-o fa-fw" aria-hidden="true"></i>&nbsp;Docente
                    </a>
                    @endpermission
                    @permission('find.disponible')
                    <div class="dropdown-divider"></div>  <!-- linea separadora -->
                    <a class="dropdown-item" href="{{route('solicitud.sala.find')}}">
                        <i class="fa fa-building-o fa-fw" aria-hidden="true"></i>&nbsp;Sala
                    </a>
                    @endpermission
                </div>
            </div>
            @endpermission
            <!-- fin submenu buscar-->
            <!-- submenu mantenedores -->
            @permission('list.user|list.perfil|list.sala|list.piso|list.edificio|list.motivo|list.cargaacademica|list.disponible|list.carrera|list.asignatura')
            <div class="dropdown">
                <a class="nav-item nav-link dropdown-toggle" href="#" id="sub-crear"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                    <i class="fa fa-wrench" aria-hidden="true"></i>&nbsp;MANTENEDORES
                </a>
                <div class="dropdown-menu dropdown-menu-left" aria-labelledby="sub-crear" >
                    @permission('list.user')
                    <a class="dropdown-item" href="{{route('usuario.list')}}">
                        <i class="fa fa-user fa-fw" aria-hidden="true"></i>&nbsp;Usuario
                    </a>
                    @endpermission
                    @permission('list.perfil')
                    <a class="dropdown-item" href="{{route('perfiles.list')}}">
                        <i class="fa fa-user fa-fw" aria-hidden="true"></i>&nbsp;Perfiles
                    </a>
                    @endpermission
                    <div class="dropdown-divider"></div>  <!-- linea separadora -->
                    @permission('list.carrera')
                    <a class="dropdown-item" href="{{route('carrera.list')}}">
                        <i class="fa fa-cube fa-fw" aria-hidden="true"></i>&nbsp;Carreras
                    </a>
                    @endpermission
                    <div class="dropdown-divider"></div>  <!-- linea separadora -->
                    @permission('list.sala')
                    <a class="dropdown-item" href="{{route('sala.list')}}">
                        <i class="fa fa-building-o fa-fw" aria-hidden="true"></i>&nbsp;Sala
                    </a>
                    @endpermission
                    @permission('list.piso')
                    <a class="dropdown-item" href="{{route('piso.list')}}">
                        <i class="fa fa-building-o fa-fw" aria-hidden="true"></i>&nbsp;Piso
                    </a>
                    @endpermission
                    @permission('list.edificio')
                    <a class="dropdown-item" href="{{route('edificio.list')}}">
                        <i class="fa fa-building-o fa-fw" aria-hidden="true"></i>&nbsp;Edificio
                    </a>
                    @endpermission
                    <div class="dropdown-divider"></div>  <!-- linea separadora -->
                    @permission('list.motivo')
                    <a class="dropdown-item" href="{{route('motivo.list')}}">
                        <i class="fa fa-list-ol fa-fw" aria-hidden="true"></i>&nbsp;Motivo
                    </a>
                    @endpermission
                    @permission('list.cargaacademica')
                    <a class="dropdown-item" href="{{route('CA.list')}}">
                        <i class="fa fa-calendar fa-fw" aria-hidden="true"></i>&nbsp;Carga Academica
                    </a>
                    @endpermission
                    @permission('list.disponible')
                    <a class="dropdown-item" href="{{route('disponibilidad.list')}}">
                        <i class="fa fa-clock-o fa-fw" aria-hidden="true"></i>&nbsp;Disponibilidad por Sala
                    </a>
                    @endpermission
                    @permission('list.disponible')
                    <a class="dropdown-item" href="{{route('disponibilidad.list-horario')}}">
                        <i class="fa fa-clock-o fa-fw" aria-hidden="true"></i>&nbsp;Disponibilidad por Horario
                    </a>
                    @endpermission
                </div>
            </div>
            @endpermission
            <!-- fin submenu mantenedores -->
            @permission('list.solicitud')
            <a class="nav-item nav-link" href="{{route('solicitud.index')}}">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;SOLICITUDES</a>
            @endpermission

            @permission('list.misolicitud|list.micargaacademica')
            <div class="dropdown">
                <a class="nav-item nav-link dropdown-toggle" href="#" id="sub-personal"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                    <i class="fa fa-user fa-fw" aria-hidden="true"></i>&nbsp;PERSONAL
                </a>
                <div class="dropdown-menu dropdown-menu-left" aria-labelledby="sub-personal" >
                    @permission('list.misolicitud')
                    <a class="dropdown-item" href="{{route('miSolicitud.index')}}">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;Mis Solicitudes
                    </a>
                    @endpermission
                    @permission('list.micargaacademica')
                    <a class="dropdown-item" href="{{route('miCargaAcad.index')}}">
                        <i class="fa fa-calendar fa-fw" aria-hidden="true"></i>&nbsp;Mi Carga Academica
                    </a>
                    @endpermission
                </div>
            </div>

            @endpermission
            @permission('list.reporte')
            <div class="dropdown" >
                <a class="nav-item nav-link dropdown-toggle" href="#" id="sub-reporte"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                    <i class="fa fa-book" aria-hidden="true"></i>&nbsp;REPORTES
                </a>
                <div class="dropdown-menu dropdown-menu-left" aria-labelledby="sub-reporte" >
                    <a class="dropdown-item" href="{{route('reporte.sala-top')}}">
                        <i class="fa fa-book fa-fw" aria-hidden="true"></i>&nbsp;Sala mas Solicitada
                    </a>
                    <a class="dropdown-item" href="{{route('reporte.horario-top')}}">
                        <i class="fa fa-book fa-fw" aria-hidden="true"></i>&nbsp;Horario mas Solicitado
                    </a>
                    <a class="dropdown-item" href="{{route('reporte.solicitante-top')}}">
                        <i class="fa fa-book fa-fw" aria-hidden="true"></i>&nbsp;Solicitantes más activos
                    </a>
                    <a class="dropdown-item" href="{{route('reporte.carrera-top')}}">
                        <i class="fa fa-book fa-fw" aria-hidden="true"></i>&nbsp;Carreras más activas
                    </a>
                    <a class="dropdown-item" href="{{route('reporte.logs')}}">
                        <i class="fa fa-book fa-fw" aria-hidden="true"></i>&nbsp;Logs del Sistema
                    </a>
                </div>
            </div>
            @endpermission
            <a class="nav-item nav-link" href="https://adfs.inacap.cl/adfs/ls/?wa=wsignin1.0&wtrealm=urn:federation:MicrosoftOnline&&wctx=MEST%3D0%26wa%3Dwsignin1.0%26wreply%3Dhttps:%252F%252Fwww.outlook.com%252Fowa%252Finacapmail.cl%252F" target="_blank"><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;CORREO</a>
        </div>
    </div>

    {{--  Nombre y cerrar sesion  --}}
    <div class="col-sm-2">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{--  imagen perfil  --}}
                    @role('admin')
                        <img src="{{ url('/sistema/img/admin.png')}}" alt="Administrador" title="Administrador" />
                    @endrole
                    @role('alumno')
                        <img src="{{ url('/sistema/img/alumno.png')}}" alt="Alumno Inacap" title="Alumno"/>
                    @endrole
                    @role('docente')
                        <img src="{{ url('/sistema/img/docente.png')}}" alt="Docente" title="Docente"/>
                    @endrole
                    @role('operador')
                        <img src="{{ url('/sistema/img/operador.png')}}" alt="operador" title="operador"/>
                    @endrole
                    {{--  fin imagen perfil  --}}

                    {{--  nombre  login--}}
                    &nbsp;{{ actualUser()->name }}
                    {{--  fin nombre login  --}}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="#">{{ ActualUser()->roles[0]->name }}</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;Cerrar Sesion
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </li>
        </ul>
    </div>
    {{--  fin nombre y cerrar sesion  --}}
</nav>