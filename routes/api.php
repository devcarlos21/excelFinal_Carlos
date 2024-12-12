<?php

use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioDetalleController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::get('/getUsers', [TestController::class,'getUsers']); 

// Route::get('/getUser/{id}', [TestController::class,'User']);

// Route::post('/insertUser', [TestController::class,'insertUser']);



Route::prefix('usuarios-detalles')->group(function () {
    Route::get('/', [UsuarioDetalleController::class, 'obtenerUsuariosDetalles']);
    Route::post('/', [UsuarioDetalleController::class, 'insertarUsuarioDetalle']);
    Route::get('/{id}', [UsuarioDetalleController::class, 'obtenerUsuarioDetalle']);
    Route::put('/{id}', [UsuarioDetalleController::class, 'actualizarUsuarioDetalle']);
    Route::delete('/{id}', [UsuarioDetalleController::class, 'eliminarUsuarioDetalle']);
});


// Route::post('/upload-excel', [ExcelController::class, 'upload'])->name('upload.excel');
Route::post('/upload-excel', [UsuarioDetalleController::class, 'upload'])->name('api.upload.excel');
