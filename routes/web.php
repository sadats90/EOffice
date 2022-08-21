<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

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

Route::get('/index',[TaskController::Class,'index']);
Route::post('/add',[TaskController::Class,'add']);
Route::get('assign/{id}',[TaskController::Class,'assign']);

Route::put('change_to_done/{id}',[TaskController::class,'change_to_done']);
Route::put('change_to_inProgress/{id}',[TaskController::class,'change_to_inProgress']);