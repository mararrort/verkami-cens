<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\PreventaController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::resource('editoriales', EmpresaController::class)->only(['index']);
Route::resource('editoriales', EmpresaController::class)->only(['create', 'store'])->middleware('auth');
Route::resource('preventas', PreventaController::class)->only(['index']);
Route::resource('preventas', PreventaController::class)->only(['create', 'store'])->middleware('auth');