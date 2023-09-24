<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WarehouseStatusController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/panel', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/* --- CRUD Productos
    - Crear Producto
    - Ver y Buscar Productos
    - Editar Producto
    - Eliminar Producto
*/

Route::middleware('auth')->controller(ProductController::class)->group(function () {
    Route::get('/productos', 'index')->name('products.index');
    Route::get('/productos/crear', 'create')->name('products.create');
    Route::post('/productos', 'store')->name('products.store');
    Route::get('/productos/{product}', 'show')->name('products.show');
    Route::get('/productos/{product}/editar', 'edit')->name('products.edit');
    Route::put('/productos/{product}', 'update')->name('products.update');
    Route::delete('/productos/{product}', 'destroy')->name('products.destroy');
});

/* --- Estados de Bodega
    - Ver Estados de Bodega
    - Crear Estado de Bodega
    - Leer Estado de Bodega
    - Eliminar Estado de Bodega
*/
Route::middleware('auth')->controller(WarehouseStatusController::class)->group(function () {
    Route::get('/estados-de-bodega', 'index')->name('warehouseStates.index');
    Route::get('/estados-de-bodega/crear', 'create')->name('warehouseStates.create');
    Route::post('/estados-de-bodega', 'store')->name('warehouseStates.store');
    Route::get('/estados-de-bodega/{warehouseStatus}', 'show')->name('warehouseStates.show');
    Route::delete('/estados-de-bodega/{warehouseStatus}', 'destroy')->name('warehouseStates.destroy');
});

/* --- Registros
    - Editar Registro
*/
Route::middleware('auth')->controller(RegisterController::class)->group(function () {    
    Route::get('/registros/{warehouseStatus}/{register}', 'show')->name('registers.show');
    Route::get('/registros/{warehouseStatus}/{register}/editar', 'edit')->name('registers.edit');
    Route::put('/registros/{warehouseStatus}/{register}', 'update')->name('registers.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
