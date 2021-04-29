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

// Main
Route::redirect("/", "/preventas");

// Auth
Route::get("/dashboard", function () {
    return view("dashboard");
})
    ->middleware(["auth"])
    ->name("dashboard");

require __DIR__ . "/auth.php";

// Editorial
Route::resource("editorial", EditorialController::class)->only(["index"]);

// Presales
Route::name("presales")->group(function () {
    Route::get("/preventas", [PresaleController::class, "index"])->name(
        ".index"
    );

    Route::get("preventas/{editorial}", [
        PresaleController::class,
        "index"
    ])->name(".filteredIndex");

    Route::get("/preventas/{column}/{order}", [
        PresaleController::class,
        "index"
    ])
        ->where(["column" => "(Nombre|Editorial|Estado|Financiacion|EntregaA|EntregaR|Puntualidad)", "order" => "(ASC|DESC)"])
        ->name(".orderedIndex");

    Route::get("/preventas/{editorial}/{column}/{order}", [
        PresaleController::class,
        "index"
    ])
        ->where(["column" => "(Nombre|Editorial|Estado|Financiacion|EntregaA|EntregaR|Puntualidad)", "order" => "(ASC|DESC)"])
        ->name(".filteredOrderedIndex");
});

// Petition
Route::resource("petition", PetitionController::class)->only(["store"]);
Route::get("/peticion/create/{presale?}", [
    PetitionController::class,
    "create"
])->name("petition.create");
Route::resource("petition", PetitionController::class)
    ->only(["index", "edit", "update", "destroy"])
    ->middleware("auth");
Route::get("/peticion/show/{petition}/{error?}", [
    PetitionController::class,
    "show"
])
    ->middleware("auth")
    ->name("petition.show");
Route::post("/peticion/{petition}/accept", [
    PetitionController::class,
    "accept"
])
    ->name("petition.accept")
    ->middleware("auth");

// TODO
Route::resource("todo", TODOController::class)
    ->only(["create", "store", "edit", "update", "destroy"])
    ->middleware("auth");

// Info
Route::get("info", function () {
    $privateTodo = TODO::where("type", "private")->get();
    $publicTodo = TODO::where("type", "public")->get();
    $undefinedTodo = TODO::where("type", "undecided")->get();

    return view("about", [
        "privateTodo" => $privateTodo,
        "publicTodo" => $publicTodo,
        "undefinedTodo" => $undefinedTodo
    ]);
})->name("info");
