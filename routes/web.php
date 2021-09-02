<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
    return view('admin.master');
});
Route::get('/table', function () {
   return view('admin.template.table');
});
Route::get('/form', function () {
   return view('admin.template.form');
});
Route::get('/header', function () {
   return view('clients.index');
});
Route::get('/form-user', function () {
    return view('admin.users.form');
});
