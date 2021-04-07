<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\PreventaController;
use App\Http\Controllers\SolicitudAdicionPreventaController;
use App\Http\Controllers\TODOController;
use App\Models\TODO;

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

Route::redirect('/', '/preventas');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::resource('editoriales', EmpresaController::class)->only(['index']);
Route::resource('editoriales', EmpresaController::class)->only(['create', 'store', 'edit', 'update'])->middleware('auth');

Route::resource('preventas', PreventaController::class)->only(['index']);
Route::resource('preventas', PreventaController::class)->only(['create', 'store', 'edit', 'update'])->middleware('auth');

Route::resource('peticion', SolicitudAdicionPreventaController::class)->only(['store']);
Route::get('/peticion/create/{presale?}', [SolicitudAdicionPreventaController::class, 'create'])->name('peticion.create');
Route::resource('peticion', SolicitudAdicionPreventaController::class)->only(['index', 'edit', 'update', 'show', 'destroy'])->middleware('auth');
Route::post('/peticion/{peticion}/accept', [SolicitudAdicionPreventaController::class, 'accept'])->name('peticion.accept')->middleware('auth');

Route::resource('TODO', TODOController::class)->only(['create', 'store', 'edit', 'update', 'destroy'])->middleware('auth');

Route::get('info', function() {
    $privateTodo = TODO::where('type', 'private')->get();
    $publicTodo = TODO::where('type', 'public')->get();
    $undefinedTodo = TODO::where('type', 'undecided')->get();
    return view('about', ['privateTodo' => $privateTodo, 'publicTodo' => $publicTodo, 'undefinedTodo' => $undefinedTodo]);
})->name('info');