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

Route::get('/trademarks/index', App\Http\Livewire\Trademarks\Index::class)->name('index.trademarks');
Route::get('/trademarks/create', App\Http\Livewire\Trademarks\Create::class)->name('create.trademarks');

Route::get('/clients/index', App\Http\Livewire\Clients\Index::class)->name('index.clients');
Route::get('/clients/create', App\Http\Livewire\Clients\Create::class)->name('create.clients');
