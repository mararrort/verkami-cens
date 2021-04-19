<?php

use App\Http\Controllers\EditorialController;
use App\Http\Controllers\PetitionController;
use App\Http\Controllers\PresaleController;
use App\Http\Controllers\TODOController;
use App\Models\Presale;
use App\Models\TODO;
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

Route::redirect('/', '/preventas');

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth'])
    ->name('dashboard');

require __DIR__.'/auth.php';

Route::resource('editorial', EditorialController::class)->only(['index']);

Route::get("preventas/{editorial?}", [PresaleController::class, "index"])->name(
    "presales.index",
);

Route::resource('peticion', PetitionController::class)->only(['store']);
Route::get('/peticion/create/{presale?}', [
    PetitionController::class,
    'create',
])->name('peticion.create');
Route::resource('peticion', PetitionController::class)
    ->only(['index', 'edit', 'update', 'destroy'])
    ->middleware('auth');
Route::get('/peticion/show/{petition}/{error?}', [
    PetitionController::class,
    'show',
])
    ->middleware('auth')
    ->name('petition.show');
Route::post('/peticion/{peticion}/accept', [
    PetitionController::class,
    'accept',
])
    ->name('peticion.accept')
    ->middleware('auth');

Route::resource('todo', TODOController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('auth');

Route::get('info', function () {
    $privateTodo = TODO::where('type', 'private')->get();
    $publicTodo = TODO::where('type', 'public')->get();
    $undefinedTodo = TODO::where('type', 'undecided')->get();

    return view('about', [
        'privateTodo' => $privateTodo,
        'publicTodo' => $publicTodo,
        'undefinedTodo' => $undefinedTodo,
    ]);
})->name('info');
