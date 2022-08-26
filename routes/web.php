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

//Route Hooks - Do not delete//
Route::view('especialists', 'livewire.especialists.index')->name('index.especialists')->middleware('auth');

/*|--------------------------------------------------------------------------
|Configuracion
|--------------------------------------------------------------------------*/
Route::get('/configuracion', [App\Http\Controllers\ConfiguracionController::class, 'index'])->name('index.configuracion');
Route::patch('/configuracion/update', [App\Http\Controllers\ConfiguracionController::class, 'update'])->name('update.configuracion');

Route::get('/trademarks', function () {
    return view('trademark.index');
});

Route::get('/trademarks/create', function () {
    return view('trademark.create');
});

Route::get('/trademarks/index', [App\Http\Controllers\TrademarksController::class, 'index'])->name('index.trademarks');
Route::get('/trademarks/create', [App\Http\Controllers\TrademarksController::class, 'create'])->name('create.trademarks');
// Select anidados
Route::get('/trademarks/client', [App\Http\Controllers\TrademarksController::class, 'index']);
Route::post('/trademarks/contact', [App\Http\Controllers\TrademarksController::class, 'contact']);
Route::post('/trademarks/address', [App\Http\Controllers\TrademarksController::class, 'address']);

Route::get('/clients/index', [App\Http\Controllers\ClientController::class, 'index'])->name('index.clients');
Route::get('/clients/create', [App\Http\Controllers\ClientController::class, 'create'])->name('create.clients');
Route::post('/clients/store', [App\Http\Controllers\ClientController::class, 'store'])->name('store.clients');
Route::get('/clients/edit/{id}', [App\Http\Controllers\ClientController::class, 'edit'])->name('edit.clients');
Route::patch('/clients/update/{id}', [App\Http\Controllers\ClientController::class, 'update'])->name('update.clients');
Route::delete('/clients/delete/{id}', [App\Http\Controllers\ClientController::class, 'destroy'])->name('delete.clients');


