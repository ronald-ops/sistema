<?php 

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\SeccionController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\PermisosController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\SucesosPersonalController;

// Ruta principal que redirige a la página de inicio de sesión
Route::get('/', function () {
    return view('auth.login');
});

// Rutas de autenticación (login, registro, restablecimiento de contraseña)
Auth::routes();

// Rutas para usuarios autenticados
Route::middleware(['auth'])->group(function () {

    // Ruta para el home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('empleados/{id}', [EmpleadoController::class, 'getEmpleado'])->name('empleados.get'); // Obtener datos de un empleado para edición
    
    Route::resource('empleados', EmpleadoController::class);

    // Ruta para obtener los horarios de un empleado
    Route::get('/empleados/{empleadoId}/horarios', [EmpleadoController::class, 'getHorarios']);
    // Ruta para eliminar un horario
    Route::delete('/empleados/{empleadoId}/horarios/{horarioId}', [EmpleadoController::class, 'eliminarHorario'])->name('empleados.eliminarHorario');
    // Ruta para asignar horarios a un empleado
    Route::post('empleados/{id}/asignar-horario', [EmpleadoController::class, 'asignarHorario'])->name('empleados.asignarHorario');

    // RUTAS RELACIONADAS CON HORARIOS (uso de resource)
    Route::resource('horarios', HorarioController::class);

    // RUTAS RELACIONADAS CON SECCIONES
    Route::prefix('seccion')->group(function () {
        Route::get('/administrativo', [SeccionController::class, 'administrativo'])->name('seccion.administrativo');
        Route::get('/servicios', [SeccionController::class, 'servicios'])->name('seccion.servicios');
        Route::get('/docentes', [SeccionController::class, 'docentes'])->name('seccion.docentes');
        Route::get('/pasantes', [SeccionController::class, 'pasantes'])->name('seccion.pasantes');
    });

    // RUTAS RELACIONADAS CON IMPORTACIONES
    Route::get('/Reporteimportar', [ReporteController::class, 'showImportForm'])->name('importar.form');
    Route::post('/importar', [ReporteController::class, 'import'])->name('importar');

    // RUTAS RELACIONADAS CON ASISTENCIA (uso de resource)
    Route::resource('asistencias', AsistenciaController::class);

    // RUTAS RELACIONADAS CON PERMISOS
    Route::get('/permisos/generarPermiso', [PermisosController::class, 'mostrarFormulario'])->name('permisos.form');
    Route::post('/permisos/generarReporte', [PermisosController::class, 'generarReporte'])->name('permisos.generarReporte');
    Route::get('/permisos/crear', [PermisosController::class, 'mostrarFormulario'])->name('permisos.generarPermiso');
    Route::post('/permisos', [PermisosController::class, 'store'])->name('permisos.store');

    // RUTAS DE SUCESOS MENSUAL DEL PERSONAL
    Route::get('/sucesos-personal', [SucesosPersonalController::class, 'index'])->name('sucesos.personal');
    Route::get('/sucesos-personal/export', [SucesosPersonalController::class, 'export'])->name('sucesos.export');
});
