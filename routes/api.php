<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

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

// //Users
// Route::resource('users', 'App\Http\Controllers\User\UserController' , ['except' => ['create','edit']]); 
// Route::name('verify')->get('users/verify/{token}', 'App\Http\Controllers\User\UserController@verify');

// //auth
// Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');

// //login
// Route::post('/api/login', [App\Http\Controllers\Login\LoginController::class, 'login'])->name('api.login');

//Register
Route::post('/ns/register', [RegisterController::class, 'store'])->name('api.register');
