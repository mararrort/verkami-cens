<?php

use App\Http\Controllers\EditorialController;
use App\Http\Controllers\PetitionController;
use App\Http\Controllers\PresaleController;
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

// Main
Route::redirect('/', '/preventas');

// Auth
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

// Editorial
Route::resource('editorial', EditorialController::class)->only(['index']);

// Presales
Route::name('presales')->group(function () {
    Route::get('/preventas', [PresaleController::class, 'index'])->name(
        '.index'
    );

    Route::get('preventas/{editorial}', [
        PresaleController::class,
        'index',
    ])->name('.filteredIndex');
});

// Petition
Route::resource('petition', PetitionController::class)->only(['store'])->middleware(['throttle:petitionCreate']);
Route::get('/peticion/create/{presale?}', [
    PetitionController::class,
    'create',
])->name('petition.create');
Route::resource('petition', PetitionController::class)
    ->only(['index', 'edit', 'update', 'destroy'])
    ->middleware('auth');
Route::get('/peticion/show/{petition}/{error?}', [
    PetitionController::class,
    'show',
])
    ->middleware('auth')
    ->name('petition.show');
Route::post('/peticion/{petition}/accept', [
    PetitionController::class,
    'accept',
])
    ->name('petition.accept')
    ->middleware('auth');

// Info
Route::view('info', 'about')->name('info');
