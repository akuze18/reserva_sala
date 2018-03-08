@extends('marco.public3')



@section('logear')
    @if (Auth::guest())

        <form name="sentMessage" id="contactForm" method="post" action="{{route('login')}}">
            {{ csrf_field() }}
            <div>
            <div class="control-group ">
                <div class="form-group controls mb-0 pb-2 {{ $errors->has('email') ? ' has-error' : '' }}">
                    <label>Correo</label>
                    <input class="form-control" id="email" name="email" type="email" placeholder="Correo" required="required" data-validation-required-message="Por favor ingrese su correo.">

                    <p class="help-block text-danger"></p>
                </div>
            </div>
            <div class="control-group">
                <div class="form-group controls mb-0 pb-2">
                    <label>Contraseña</label>
                    <input class="form-control" id="password" name="password" type="password" placeholder="Clave" required="required" data-validation-required-message="Por favor ingrese su clave">
                    <p class="help-block text-danger"></p>
                </div>
            </div>
            @if ($errors->has('email'))
                <p class="help-block text-danger"><strong>{{ $errors->first('email') }}</strong></p>
            @endif

            </div>
            <br>
            <div id="success"></div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg">Iniciar</button>
                <button type="button" class="btn btn-info btn-lg"  data-toggle="modal" data-target="#modalrecuperar">Recuperar Clave</button>
            </div>
        </form>

    @include('modals.recuperar_clave')

    @else
    {{--  Lo que se muestra en "Sistema" al ya estar logeado  --}}
        <div class="heading-contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-offset-2">

                    <div class="section-heading">
                        <div class="wow bounceInDown" data-wow-delay="0.4s">
                            <h2>SISTEMA</h2>
                        </div>
                        <div class="wow bounceInRight" data-wow-delay="0.4s">                            
                            <i class="fa fa-user-circle-o fa-3x" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
            <div class="col-lg-8 col-md-offset-2">
                <div class="form-wrapper marginbot-50 wow flipInX" data-wow-delay=".25s">
                    <div>
                        Hola {{ actualUser()->name }}
                    </div> 
                    <br>  {{--  {{Auth::user()->perfil }}  --}}
                        <!-- boton sesion -->
                    <div class="d-flex flex-row justify-content-center">            
                        <a href="{{route('inicio')}}" class="btn btn-info mr-2">
                            <i class="fa fa-undo" aria-hidden="true"></i>&nbsp; Volver al Sistema
                        </a>
                        <br>
                        <br>
                
                        <a href="{{ route('logout') }}" class="btn btn-info mr-2"
                        onclick="event.preventDefault();
                                                                document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp; Cerrar Sesion
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>

                    </div>
                        <!-- fin btn sesion -->
                    
                </div>
            </div>
        </div>      


    @endif

@endsection