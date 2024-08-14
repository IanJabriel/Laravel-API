<?php

use App\Http\Controllers\AcceptController;
use App\Http\Controllers\Api\v1\CursosController;
use App\Http\Controllers\Api\v1\NewPasswordController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\v1\UsuariosController;
use App\Http\Controllers\AuthController;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\URL;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function(){
    Route::get('/usuarios',[UsuariosController::class,'index']);
    Route::post('/usuarios',[UsuariosController::class,'store']);

    Route::get('/cursos',[CursosController::class,'index']);

    Route::post('/login',[AuthController::class , 'login']);
    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/teste',[AcceptController::class,'index'])->middleware('auth:sanctum');
        Route::get('/usuarios/{usuario}',[UsuariosController::class, 'show'])->middleware('ability:usuario-get');
        Route::post('/logout',[AuthController::class, 'logout']);
    });

    Route::post('/forgot-password',[NewPasswordController::class,'forgotPassword'])->name('password.reset');

    Route::get('/forgot-password/{token}', function(string $token){
        $resetURL = URL::temporarySignedRoute(
            'password.reset', now()->addMinutes(60),['token' => $token]
        );
    })->name('password.reset');

    Route::post('/reset-password',[NewPasswordController::class, 'updatePassword'])->name('password.update');
});
