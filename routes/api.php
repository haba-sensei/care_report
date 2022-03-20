<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CampaignController;
use App\Http\Controllers\Api\V1\ReporteController;
use App\Http\Controllers\Api\V1\UsuarioController;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);
Route::get('optimize', [AuthController::class, 'optimize']);

Route::group(
    [
        'middleware' => 'jwt.verify',
        'prefix' => 'auth',
    ],
    function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'getUser']);
        Route::post('checkToken', [AuthController::class, 'checkToken']);
        Route::post('user/update', [AuthController::class, 'update']);
        Route::post('user/update/pass', [AuthController::class, 'updatePass']);
    }
);

Route::group(
    [
        'middleware' => 'jwt.verify',
        'prefix' => 'usuarios',
    ],
    function () {
        Route::post('create', [UsuarioController::class, 'createUser']);
        Route::get('editar/{id}', [UsuarioController::class, 'editUser']);
        Route::post('actualizar', [UsuarioController::class, 'actualizarUser']);
        Route::get('listar', [UsuarioController::class, 'listUser']);
        Route::get('eliminar/{id}', [UsuarioController::class, 'eliminarUser']);
    }
);

Route::group(
    [
        'middleware' => 'jwt.verify',
        'prefix' => 'campaign',
    ],
    function () {
        Route::post('create', [CampaignController::class, 'create']);
        Route::post('actualizar', [CampaignController::class, 'actualizar']);
        Route::get('listar', [CampaignController::class, 'listar']);
        Route::get('detalles/{id}', [CampaignController::class, 'detalles']);
        Route::get('eliminar/{id}', [CampaignController::class, 'eliminar']);
    }
);


Route::group([
    'middleware' => 'jwt.verify',
    'prefix' => 'reportes',
], function () {
    Route::get('basico', [ReporteController::class, 'basico']);
    Route::get('general/{rango}', [ReporteController::class, 'general']);
    Route::get('unico/{rango}', [ReporteController::class, 'unico']);
    Route::get('mensual/{rango}', [ReporteController::class, 'mensual']);
    Route::get('donadores', [ReporteController::class, 'donadores']);
    Route::get('allReport/{rango}', [ReporteController::class, 'allReport']);
});



