<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('inicio');

// Authentication Routes...
Route::get('login', 'HomeController@login')->name('login');
Route::post('login', 'Auth\LoginController@ingreso');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
//Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register')->middleware('authenticated');
//Route::post('register', 'Auth\RegisterController@register')->middleware('authenticated');

// Password Reset Routes...
//Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@resetear')->name('password.set');


Route::prefix('sistema')->middleware(['auth','web'])->group(function(){
    Route::get('nueva_pass',function(){return view('sistema.cambiar-password');})->name('nueva_pass');
    Route::post('cambio_pass/{id_usuario}','UserController@update')->name('cambio_pass');
    Route::middleware('CambiarPass')->group(function(){
        Route::get('home','HomeController@sistema_home')->name('ingreso_sistema');
        Route::prefix('personal')->group(function(){
            Route::get('mis-solicitudes/{estado?}','PersonalController@solicitudes')->name('miSolicitud.index')
                ->middleware('permission:list.misolicitud');
            Route::get('mi-carga-academica','PersonalController@cargas_academicas')->name('miCargaAcad.index')
                ->middleware('permission:list.micargaacademica');
        });

        Route::get('solicitudes/{estado?}','SolicitudController@index')->name('solicitud.index')
            ->middleware('permission:list.solicitud');

        Route::post('solicitud/store','SolicitudController@procesar')->name('solicitud.store')
            ->middleware('permission:edit.solicitud');

        Route::get('sala/buscar','SolicitudController@sala_find')->name('solicitud.sala.find')
            ->middleware('permission:find.disponible');

        Route::post('solicitud/sala/store','SolicitudController@sala_pedir')->name('solicitud.sala.store')
            ->middleware('permission:create.solicitud');

        Route::get('docente/buscar','CargaAcademicaController@search')->name('CA.search')
            ->middleware('permission:find.docente');

        Route::prefix('salas')->group(function(){
            Route::get('mantenedor','SalaController@index')->name('sala.list')
                ->middleware('permission:list.sala');
            Route::get('crear','SalaController@create')->name('sala.create')
                ->middleware('permission:create.sala');
            Route::post('guardar','SalaController@store')->name('sala.store')
                ->middleware('permission:create.sala');
            Route::get('detalle/{sala_id}','SalaController@show')->name('sala.show')
                ->middleware('permission:see.sala');
            Route::get('editar/{sala_id}','SalaController@edit')->name('sala.edit')
                ->middleware('permission:edit.sala');
            Route::put('actualizar/{sala_id}','SalaController@update')->name('sala.update')
                ->middleware('permission:edit.sala');
            Route::delete('borrar/{sala_id}','SalaController@destroy')->name('sala.destroy')
                ->middleware('permission:delete.sala');
        });
        Route::prefix('pisos')->group(function(){
            Route::get('mantenedor','PisoController@index')->name('piso.list')
                ->middleware('permission:list.piso');
            Route::get('crear','PisoController@create')->name('piso.create')
                ->middleware('permission:create.piso');
            Route::post('guardar','PisoController@store')->name('piso.store')
                ->middleware('permission:create.piso');
            Route::get('detalle/{piso_id}','PisoController@show')->name('piso.show')
                ->middleware('permission:see.piso');
            Route::get('editar/{piso_id}','PisoController@edit')->name('piso.edit')
                ->middleware('permission:edit.piso');
            Route::put('actualizar/{piso_id}','PisoController@update')->name('piso.update')
                ->middleware('permission:edit.piso');
            Route::delete('borrar/{piso_id}','PisoController@destroy')->name('piso.destroy')
                ->middleware('permission:delete.piso');
        });
        Route::prefix('edificios')->group(function(){
            Route::get('mantenedor','EdificioController@index')->name('edificio.list')
                ->middleware('permission:list.edificio');
            Route::get('crear','EdificioController@create')->name('edificio.create')
                ->middleware('permission:create.edificio');
            Route::post('guardar','EdificioController@store')->name('edificio.store')
                ->middleware('permission:create.edificio');
            Route::get('detalle/{edificio_id}','EdificioController@show')->name('edificio.show')
                ->middleware('permission:see.edificio');
            Route::get('editar/{edificio_id}','EdificioController@edit')->name('edificio.edit')
                ->middleware('permission:edit.edificio');
            Route::put('actualizar/{edificio_id}','EdificioController@update')->name('edificio.update')
                ->middleware('permission:edit.edificio');
            Route::delete('borrar/{edificio_id}','EdificioController@destroy')->name('edificio.destroy')
                ->middleware('permission:delete.edificio');
        });
        Route::prefix('motivos')->group(function(){
            Route::get('mantenedor','MotivoController@index')->name('motivo.list')
                ->middleware('permission:list.motivo');
            Route::get('crear','MotivoController@create')->name('motivo.create')
                ->middleware('permission:create.motivo');
            Route::post('guardar','MotivoController@store')->name('motivo.store')
                ->middleware('permission:create.motivo');
            Route::get('detalle/{motivo_id}','HomeController@TODO')->name('motivo.show')
                ->middleware('permission:see.motivo');
            Route::get('editar/{motivo_id}','MotivoController@edit')->name('motivo.edit')
                ->middleware('permission:edit.motivo');
            Route::put('actualizar/{motivo_id}','MotivoController@update')->name('motivo.update')
                ->middleware('permission:edit.motivo');
            Route::delete('borrar/{motivo_id}','MotivoController@destroy')->name('motivo.destroy')
                ->middleware('permission:delete.motivo');
        });
        Route::prefix('carga_academica')->group(function(){
            Route::get('mantenedor','CargaAcademicaController@index')->name('CA.list')
                ->middleware('permission:list.cargaacademica');
            Route::get('crear/{docente_id}/{horario_id}','CargaAcademicaController@create')->name('CA.create')
                ->middleware('permission:create.cargaacademica');
            Route::post('guardar','CargaAcademicaController@store')->name('CA.store')
                ->middleware('permission:create.cargaacademica');
            Route::get('detalle/{docente_id}','CargaAcademicaController@detail')->name('CA.detail')
                ->middleware('permission:see.cargaacademica');
            Route::get('editar/{ca_id}','CargaAcademicaController@edit')->name('CA.edit')
                ->middleware('permission:edit.cargaacademica');
            Route::put('actualizar/{ca_id}','CargaAcademicaController@update')->name('CA.update')
                ->middleware('permission:edit.cargaacademica');
            Route::delete('borrar/{ca_id}','CargaAcademicaController@destroy')->name('CA.destroy')
                ->middleware('permission:delete.cargaacademica');
        });
        Route::prefix('disponibilidades')->group(function(){
            Route::get('salas','DisponibilidadController@index_salas')->name('disponibilidad.list')
                ->middleware('permission:list.disponible');
            Route::get('salas/{sala_id}','DisponibilidadController@index_salas2')->name('disponibilidad.list-salas2')
                ->middleware('permission:list.disponible');
            Route::get('horarios','DisponibilidadController@index_horario')->name('disponibilidad.list-horario')
                ->middleware('permission:list.disponible');
            Route::get('horarios/{horario_id}','DisponibilidadController@index_horario2')->name('disponibilidad.list-horario2')
                ->middleware('permission:list.disponible');

            Route::post('actualizar','DisponibilidadController@update')->name('disponibilidad.update')
                ->middleware('permission:edit.disponible');
        });
        Route::prefix('usuarios')->group(function(){
            Route::get('mantenedor','UserController@index')->name('usuario.list')
                ->middleware('permission:list.user');
            Route::get('inactivos','UserController@index_inactive')->name('usuario.list-inactive')
                ->middleware('permission:list.user');
            Route::get('crear','UserController@create')->name('usuario.create')->middleware('role:admin')
                ->middleware('permission:create.user');
            Route::post('guardar','UserController@store')->name('usuario.store')
                ->middleware('permission:create.user');
            Route::get('detalle/{usuario_id}','UserController@show')->name('usuario.show')
                ->middleware('permission:see.user');
            Route::get('editar/{usuario_id}','UserController@edit')->name('usuario.edit')
                ->middleware('permission:edit.user');
            Route::put('actualizar/{usuario_id}','UserController@update')->name('usuario.update')
                ->middleware('permission:edit.user');
            Route::delete('borrar/{usuario_id}','UserController@destroy')->name('usuario.destroy')
                ->middleware('permission:disable.user');
            Route::delete('inactivos/{usuario_id}','UserController@restore')->name('usuario.restore')
                ->middleware('permission:create.user');
        });
        Route::prefix('perfiles')->group(function(){
            Route::get('mantenedor','PerfilController@index')->name('perfiles.list')
                ->middleware('permission:list.perfil');
            Route::get('crear','PerfilController@create')->name('perfiles.create')
                ->middleware('permission:create.perfil');
            Route::post('guardar','PerfilController@store')->name('perfiles.store')
                ->middleware('permission:create.perfil');
            Route::get('detalle/{role_slug}','PerfilController@show')->name('perfiles.show')
                ->middleware('permission:see.perfil');
            Route::get('editar/{role_slug}','PerfilController@edit')->name('perfiles.edit')
                ->middleware('permission:edit.perfil');
            Route::put('actualizar/{role_slug}','PerfilController@update')->name('perfiles.update')
                ->middleware('permission:edit.perfil');
            Route::delete('borrar/{role_slug}','HomeController@TODO')->name('perfiles.destroy')
                ->middleware('permission:delete.perfil');
        });

        Route::prefix('carreras')->group(function(){
            Route::get('mantenedor','CarreraController@index')->name('carrera.list')
                ->middleware('permission:list.carrera');
            Route::get('crear','CarreraController@create')->name('carrera.create')
                ->middleware('permission:create.carrera');
            Route::post('guardar','CarreraController@store')->name('carrera.store')
                ->middleware('permission:create.carrera');
            Route::get('detalle/{carrera_id}','CarreraController@show')->name('carrera.show')
                ->middleware('permission:see.carrera');
            Route::get('editar/{carrera_id}','CarreraController@edit')->name('carrera.edit')
                ->middleware('permission:edit.carrera');
            Route::put('actualizar/{carrera_id}','CarreraController@update')->name('carrera.update')
                ->middleware('permission:edit.carrera');
            Route::delete('borrar/{carrera_id}','CarreraController@destroy')->name('carrera.destroy')
                ->middleware('permission:delete.carrera');
        });
        Route::prefix('asignaturas')->group(function(){
            Route::get('carrera/{carrera_id}','AsignaturaController@index')->name('asignatura.list')
                ->middleware('permission:list.asignatura');
            Route::get('crear/{carrera_id}','AsignaturaController@create')->name('asignatura.create')
                ->middleware('permission:create.asignatura');
            Route::post('guardar/{carrera_id}','AsignaturaController@store')->name('asignatura.store')
                ->middleware('permission:create.asignatura');
            Route::get('detalle/{asignatura_id}','AsignaturaController@show')->name('asignatura.show')
                ->middleware('permission:see.asignatura');
            Route::get('editar/{asignatura_id}','AsignaturaController@edit')->name('asignatura.edit')
                ->middleware('permission:edit.asignatura');
            Route::put('actualizar/{asignatura_id}','AsignaturaController@update')->name('asignatura.update')
                ->middleware('permission:edit.asignatura');
            Route::delete('borrar/{asignatura_id}','AsignaturaController@destroy')->name('asignatura.destroy')
                ->middleware('permission:delete.asignatura');
        });

        Route::prefix('reportes')->group(function(){
            Route::middleware(['permission:list.reporte'])->group(function(){
                Route::match(array('GET', 'POST'),'salas-top','ReporteController@sala_top')->name('reporte.sala-top');
                Route::match(array('GET', 'POST'),'horarios-top','ReporteController@horario_top')->name('reporte.horario-top');
                Route::match(array('GET', 'POST'),'solicitantes-top','ReporteController@solicitante_top')->name('reporte.solicitante-top');
                Route::match(array('GET', 'POST'),'carrera-top','ReporteController@carrera_top')->name('reporte.carrera-top');
                Route::match(array('GET', 'POST'),'logs','ReporteController@logs')->name('reporte.logs');
            });
        });
    });
});

Route::get('denied_route','HomeController@deniedRole')->name('denyRoute');

Route::get('test2',function(){
    $ayer = strtotime('-1 day');
    //dd($ayer);
    $hoy = date('N',$ayer);
    dd($hoy);

    $fecha = new datetime();
    $fecha2= new datetime();

    $inicial = $fecha->modify('first day of');
    $final = $fecha2->modify('last day of');
    dd($inicial);
    //dd($final);
    return 0;

    $ini = $fecha->format('Y').'-'.$fecha->format('m').'-01';

    //dd($ini.' '.$fin);
    $inicial = date_create_from_format('Y-m-d',$ini );
    $max = 31;
    do{
        $corregir = false;
        if(!checkdate($fecha->format('m'),$max,$fecha->format('Y'))){
            $corregir=true;
            $max--;
        }
        else{
            $fin = $fecha->format('Y').'-'.$fecha->format('m').'-'.$max;
            $final = date_create_from_format('Y-m-d',$fin);
        }

    }while($corregir);

    //dd($inicial);
    echo('desde: '.$inicial->format('Y-m-d').'<br>hasta: '.$final->format('Y-m-d'));
});

Route::get('test',function(){

    $algo = \App\Dia::where('id',4)->first()->es;
    dd($algo);
    return

    $algo = CargaAcademica::class;
    dd(gettype($algo));

    $ddd = \Ultraware\Roles\Models\Role::where('slug','admin')->first();
    //dd($ddd);
    $docentes = $ddd->users;
    dd($docentes);
    return;

    echo '<form method="post" action="'.route('getDisponibilidad').'"><input name="parentId" value=1><button type="submit">aca</button></form>';
    return;


    $disponibilidad = \App\Disponibilidad::where('estado','<>','Disponible')->first();
    if(is_a($disponibilidad->tomado_actual()->tomable,\App\Solicitud::class)){
        echo ($disponibilidad->tomado_actual()->tomable->user->name);
    }
    else{
        echo 'no es'.\App\Solicitud::class;
    }
    //dd($disponibilidad->tomado_actual()->tomable);
    return;

    echo '<form method="post" action="'.route('getPisos').'"><input name="edificioId" value=1><button type="submit">aca</button></form>';
    return;

    $sala = \App\Sala::buscar('B')->get();
    dd($sala);
    $fecha = date('H:i',strtotime('08:30:00'));
    echo $fecha.'<br>';
    echo date('H:i',strtotime($fecha.' + 45 minutes'));
    return;
    $fecha= strtotime('+45 minute',strtotime($fecha));
    echo $fecha;
    return;
    dd($fecha->format('H:i'));

    $salas = \App\Sala::all();
    foreach($salas as $sala){
        print 'La sala: '.$sala->name.' del piso '.$sala->piso->name.' esta en el edificio '. $sala->piso->edificio->name.'<br>';
    }
});




