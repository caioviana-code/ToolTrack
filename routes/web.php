<?php

use App\Http\Controllers\FerramentaController;
use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider;

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

Route::resource('/ferramentas', 'FerramentaController');
Route::resource('/emprestimos', 'EmprestimoController');
Route::resource('/reservas', 'ReservaController');

/*
Route::get('/ferramentas', [FerramentaController::class, 'index'])->name('ferramentas.index');
Route::get('/ferramentas/create', [FerramentaController::class, 'create'])->name('ferramentas.create');
Route::post('/ferramentas', [FerramentaController::class, 'store'])->name('ferramentas.store');
Route::get('/ferramentas/{ferramenta}/edit', [FerramentaController::class, 'edit'])->name('ferramentas.edit');
Route::put('/ferramentas/{ferramenta}', [FerramentaController::class, 'update'])->name('ferramentas.update');
Route::delete('/ferramentas/{ferramenta}', [FerramentaController::class, 'destroy'])->name('ferramentas.destroy');
*/
require __DIR__.'/auth.php';
