<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PermisosController;


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
    return view('auth.login');
});

Auth::routes();

Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

Route::get('/lang/change', [HomeController::class, 'change'])->name('changeLang');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('permisos', PermisosController::class);
    Route::resource('users', UserController::class);
});

/*|--------------------------------------------------------------------------
|Configuracion
|--------------------------------------------------------------------------*/
Route::get('/configuracion', [App\Http\Controllers\ConfiguracionController::class, 'index'])->name('index.configuracion');
Route::patch('/configuracion/update', [App\Http\Controllers\ConfiguracionController::class, 'update'])->name('update.configuracion');

/*|--------------------------------------------------------------------------
|Clients
|--------------------------------------------------------------------------*/
Route::get('/clients/index', [App\Http\Controllers\ClientController::class, 'index'])->name('index.clients');
Route::get('/clients/advance', [App\Http\Controllers\ClientController::class, 'advance'])->name('advance_search.clients');
Route::get('/clients/create', [App\Http\Controllers\ClientController::class, 'create'])->name('create.clients');
Route::post('/clients/store', [App\Http\Controllers\ClientController::class, 'store'])->name('store.clients');
Route::get('/clients/edit/{id}', [App\Http\Controllers\ClientController::class, 'edit'])->name('edit.clients');
Route::patch('/clients/update/{id}', [App\Http\Controllers\ClientController::class, 'update'])->name('update.clients');
Route::delete('/clients/delete/{id}', [App\Http\Controllers\ClientController::class, 'destroy'])->name('delete.clients');

/*|--------------------------------------------------------------------------
|Holder
|--------------------------------------------------------------------------*/
Route::get('/holder/index', [App\Http\Controllers\HolderController::class, 'index'])->name('index.holder');
Route::get('/holder/create', [App\Http\Controllers\HolderController::class, 'create'])->name('create.holder');
Route::post('/holder/store', [App\Http\Controllers\HolderController::class, 'store'])->name('store.holder');
Route::get('/holder/edit/{id}', [App\Http\Controllers\HolderController::class, 'edit'])->name('edit.holder');
Route::patch('/holder/update/{id}', [App\Http\Controllers\HolderController::class, 'update'])->name('update.holder');
Route::delete('/holder/delete/{id}', [App\Http\Controllers\HolderController::class, 'destroy'])->name('delete.holder');

/*|--------------------------------------------------------------------------
|Trademarks
|--------------------------------------------------------------------------*/
Route::get('/trademarks/index', [App\Http\Controllers\TrademarksController::class, 'index'])->name('index.trademarks');
Route::get('/trademarks/advance', [App\Http\Controllers\TrademarksController::class, 'advance'])->name('advance_search');
Route::get('/trademarks/create', [App\Http\Controllers\TrademarksController::class, 'create'])->name('create.trademarks');
Route::post('/trademarks/store', [App\Http\Controllers\TrademarksController::class, 'store'])->name('store.trademarks');
Route::get('/trademarks/edit/{id}', [App\Http\Controllers\TrademarksController::class, 'edit'])->name('edit.trademarks');
Route::patch('/trademarks/update/{id}', [App\Http\Controllers\TrademarksController::class, 'update'])->name('update.trademarks');

// Select anidado
Route::get('/trademarks/crear/{id}', [App\Http\Controllers\TrademarksController::class, 'GetClientAgainstMainCatEdit']);
Route::get('/trademarks/address/{id}', [App\Http\Controllers\TrademarksController::class, 'GetAddressAgainstMainCatEdit']);

Route::get('/trademarks/holder/{id}', [App\Http\Controllers\TrademarksController::class, 'GetHolderAgainstMainCatEdit']);
Route::get('/trademarks/holder/industrial/{id}', [App\Http\Controllers\TrademarksController::class, 'GetHolderIAgainstMainCatEdit']);
