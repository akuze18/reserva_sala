<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="{{route('ingreso_sistema')}}">{{env('APP_NAME')}}</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
            @yield('panelIzq')
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                <a class="nav-link" href="{{route('ingreso_sistema')}}">
                    <i class="fa fa-home fa-fw"></i>
                    <span class="nav-link-text">MI PERFIL</span>
                </a>
            </li>
            <!-- submenu buscar-->
            @permission('find.docente|find.disponible')
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="buscar">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseBuscar" data-parent="#exampleAccordion">
                    <i class="fa fa-search"></i>
                    <span class="nav-link-text">BUSCAR</span>
                </a>
                <ul class="sidenav-second-level collapse" id="collapseBuscar">
                    @permission('find.docente')
                    <li>
                        <a href="{{route('CA.search')}}">
                            <i class="fa fa-building-o fa-fw" aria-hidden="true"></i>&nbsp;Docente
                        </a>
                    </li>
                    @endpermission
                    @permission('find.disponible')
                    <li>
                        <a href="{{route('solicitud.sala.find')}}">
                            <i class="fa fa-building-o fa-fw" aria-hidden="true"></i>&nbsp;Sala
                        </a>
                    </li>
                    @endpermission
                </ul>
            </li>
            @endpermission
            <!-- fin submenu buscar-->
            <!-- submenu mantenedores -->
            @permission('list.user|list.perfil|list.sala|list.piso|list.edificio|list.motivo|list.cargaacademica|list.disponible|list.carrera|list.asignatura')
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Mantenedores">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMantenedores" data-parent="#exampleAccordion">
                    <i class="fa fa-fw fa-wrench"></i>
                    <span class="nav-link-text">MANTENEDORES</span>
                </a>
                <ul class="sidenav-second-level collapse" id="collapseMantenedores">
                    @permission('list.user')
                    <li>
                        <a href="{{route('usuario.list')}}">
                            <i class="fa fa-user fa-fw" aria-hidden="true"></i>&nbsp;Usuario
                        </a>
                    </li>
                    @endpermission
                    @permission('list.perfil')
                    <li>
                        <a href="{{route('perfiles.list')}}">
                            <i class="fa fa-user fa-fw" aria-hidden="true"></i>&nbsp;Perfiles
                        </a>
                    </li>
                    @endpermission
                    <li class="dropdown-divider"></li>  <!-- linea separadora -->
                    @permission('list.carrera')
                    <li>
                        <a href="{{route('carrera.list')}}">
                            <i class="fa fa-cube fa-fw" aria-hidden="true"></i>&nbsp;Carreras
                        </a>
                    </li>
                    @endpermission
                    <li class="dropdown-divider"></li>  <!-- linea separadora -->
                    @permission('list.sala')
                    <li>
                        <a href="{{route('sala.list')}}">
                            <i class="fa fa-building-o fa-fw" aria-hidden="true"></i>&nbsp;Sala
                        </a>
                    </li>
                    @endpermission
                    @permission('list.piso')
                    <li>
                        <a href="{{route('piso.list')}}">
                            <i class="fa fa-building-o fa-fw" aria-hidden="true"></i>&nbsp;Piso
                        </a>
                    </li>
                    @endpermission
                    @permission('list.edificio')
                    <li>
                        <a href="{{route('edificio.list')}}">
                            <i class="fa fa-building-o fa-fw" aria-hidden="true"></i>&nbsp;Edificio
                        </a>
                    </li>
                    @endpermission
                    <li class="dropdown-divider"></li>  <!-- linea separadora -->
                    @permission('list.motivo')
                    <li>
                        <a href="{{route('motivo.list')}}">
                            <i class="fa fa-list-ol fa-fw" aria-hidden="true"></i>&nbsp;Motivo
                        </a>
                    </li>
                    @endpermission
                    @permission('list.cargaacademica')
                    <li>
                        <a href="{{route('CA.list')}}">
                            <i class="fa fa-calendar fa-fw" aria-hidden="true"></i>&nbsp;Carga Academica
                        </a>
                    </li>
                    @endpermission
                    @permission('list.disponible')
                    <li>
                        <a href="{{route('disponibilidad.list')}}">
                            <i class="fa fa-clock-o fa-fw" aria-hidden="true"></i>&nbsp;Disponibilidad por Sala
                        </a>
                    </li>
                    @endpermission
                    @permission('list.disponible')
                    <li>
                        <a href="{{route('disponibilidad.list-horario')}}">
                            <i class="fa fa-clock-o fa-fw" aria-hidden="true"></i>&nbsp;Disponibilidad por Horario
                        </a>
                    </li>
                    @endpermission
                </ul>
            </li>
            @endpermission
            <!-- fin submenu mantenedores -->
            @permission('list.solicitud')
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="solicitudes">
                <a class="nav-link" href="{{route('solicitud.index')}}">
                    <i class="fa fa-pencil-square-o"></i>
                    <span class="nav-link-text">SOLICITUDES</span>
                </a>
            </li>
            @endpermission
            @permission('list.misolicitud|list.micargaacademica')
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="personal">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapsePersonal" data-parent="#exampleAccordion">
                    <i class="fa fa-user fa-fw"></i>
                    <span class="nav-link-text">PERSONAL</span>
                </a>
                <ul class="sidenav-second-level collapse" id="collapsePersonal">
                    @permission('list.misolicitud')
                    <li>
                        <a href="{{route('miSolicitud.index')}}">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;Mis Solicitudes
                        </a>
                    </li>
                    @endpermission
                    @permission('list.micargaacademica')
                    <li>
                        <a href="{{route('miCargaAcad.index')}}">
                            <i class="fa fa-calendar fa-fw" aria-hidden="true"></i>&nbsp;Mi Carga Academica
                        </a>
                    </li>
                    @endpermission
                </ul>
            </li>
            @endpermission
            @permission('list.reporte')
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Reporte">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseReporte" data-parent="#exampleAccordion">
                    <i class="fa fa-book"></i>
                    <span class="nav-link-text">REPORTES</span>
                </a>
                <ul class="sidenav-second-level collapse" id="collapseReporte">
                    <li>
                        <a href="{{route('reporte.sala-top')}}">
                            <i class="fa fa-book fa-fw" aria-hidden="true"></i>&nbsp;Sala mas Solicitada
                        </a>
                    </li>
                    <li>
                        <a href="{{route('reporte.horario-top')}}">
                            <i class="fa fa-book fa-fw" aria-hidden="true"></i>&nbsp;Horario mas Solicitado
                        </a>
                    </li>
                    <li>
                        <a href="{{route('reporte.solicitante-top')}}">
                            <i class="fa fa-book fa-fw" aria-hidden="true"></i>&nbsp;Solicitantes más activos
                        </a>
                    </li>
                    <li>
                        <a href="{{route('reporte.carrera-top')}}">
                            <i class="fa fa-book fa-fw" aria-hidden="true"></i>&nbsp;Carreras más activas
                        </a>
                    </li>
                    <li>
                        <a href="{{route('reporte.logs')}}">
                            <i class="fa fa-book fa-fw" aria-hidden="true"></i>&nbsp;Logs del Sistema
                        </a>
                    </li>
                </ul>
            </li>
            @endpermission
        </ul>
        <ul class="navbar-nav sidenav-toggler">
            <li class="nav-item">
                <a class="nav-link text-center" id="sidenavToggler">
                    <i class="fa fa-fw fa-angle-left"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ actualUser()->name }}
                </a>
                <div class="dropdown-menu" aria-labelledby="alertsDropdown">
                    <a class="dropdown-item" href="#">
                        {{ ActualUser()->roles[0]->name }}
                    </a>
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
</nav>
