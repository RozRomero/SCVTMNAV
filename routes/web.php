<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RRHHController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AprobacionController;
use App\Http\Controllers\VacacionesController;
use App\Http\Controllers\Admin\RolePermissionsController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DepartamentoController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::controller(UserController::class)->group(function () {
        /* NO usar MAKE make Make en las rutas */
        Route::get('/dashboard/mi-perfil', 'verPerfil')->name('vistaPerfil');
        Route::get('/dashboard/Catalogo-Empleados', [UserController::class, 'catalogo_empleados'])->name('catalogo_empleados');
        Route::get('/dashboard/Registrar-Empleado/{id}', 'registro_usuario')->name('registrarUsuario');
        Route::post('/dashboard/Crear-Empleado', 'crear_usuario')->name('crearUsuario');
    });

    Route::controller(VacacionesController::class)->group(function () {
        /* NO usar MAKE make Make en las rutas */
        Route::get('/dashboard/Solicitud-Vacaciones', 'vista_solicitud_vacaciones')->name('vistaSolicitudVacaciones');
        Route::post('/dashboard/Enviar-Solicitud', 'enviar_solicitud_vacaciones')->name('enviarSolicitudVacaciones');
    });

    Route::controller(RRHHController::class)->group(function () {
        /* NO usar MAKE make Make en las rutas */
        Route::get('/dashboard/Alimentar-Sistema', 'show_add_info')->name('alimentarSistema');//CARGA MASIVA DE ALAM , PARA ALIMENTAR EL SISTEMA
        Route::post('/dashboard/Alimentar-Sistema', 'set_info_users')->name('cargarEnSistema');//CARGA MASIVA DE ALAM , PARA ALIMENTAR EL SISTEMA
        // Route::get('/dashboard/Catalogo-Empleados', 'show_catalogo_empleados')->name('catalogoDeEmpleados');//catalogo de empleados para revisar dias de vacaciones e historial de vacaciones solicitado
    });

    Route::controller(AprobacionController::class)->group(function () {
        /* NO usar MAKE make Make en las rutas */
        Route::get('/dashboard/Aprobar-Vacaciones', 'index_show_aprobacion')->name('aprobarVacaciones');
        Route::post('/dashboard/Enviar-Respuesta/{id_solicitud}', 'enviarRespuesta')->name('enviarRespuesta');
    });

    // Route::group(['middleware' => ['role_or_permission:SUPER ADMIN']], function () {
        Route::controller(RolePermissionsController::class)->group(function () {
            //Admin Roles
            Route::get('admin/role-list', 'roleList')->name('settings.role');
            Route::get('admin/role/{id}', 'role')->name('create.role');
            Route::post('admin/role', 'rolecreate')->name('createsave.role');
            Route::get('admin/role-permission/{id}', 'roleper')->name('roleper');
            Route::post('admin/role-permission/add', 'rolePermAdd')->name('addperm.role');
            Route::post('admin/role-permission/rem', 'rolePermRem')->name('removeperm.role');

            //Admin Permission
            Route::get('admin/permission-list', 'permissionList')->name('settings.permission');
            Route::get('admin/permission/{id}', 'permission')->name('create.permission');
            Route::post('admin/permission', 'permissioncreate')->name('createsave.permission');
        });
//Sistema de Tickets
        Route::resource('tickets', TicketController::class);
        
//Funcion lista de compras
            // Ruta personalizada para remover empleado del departamento:
Route::delete('departamentos/{departamentoId}/empleado/{empleadoId}', 
[DepartamentoController::class, 'removerEmpleado']
)
->where(['departamentoId' => '[0-9]+', 'empleadoId' => '[0-9]+'])
->name('departamentos.removerEmpleado');

// Luego la ruta para eliminar departamento:
Route::delete('departamentos/{departamento}', 
[DepartamentoController::class, 'destroy']
)
->where('departamento', '[0-9]+')
->name('departamentos.destroy');

// Y finalmente, el resto de las rutas de resource:
Route::resource('departamentos', DepartamentoController::class)->middleware('auth');



});
