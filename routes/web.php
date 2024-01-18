<?php

use App\Http\Controllers\Admin\ClassesController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('classes')->controller(ClassesController::class)->group(function () {
    Route::get('/', 'index')
        ->name('admin.classes.index');

    Route::get('/create', 'create')
        ->name('admin.classes.create');

    Route::post('/', 'store')
        ->name('admin.classes.store');

    Route::get('/{id}', 'show')
        ->name('admin.classes.show');;

    Route::match(['PUT', 'PATCH'], '/{id}', 'update')
        ->name('admin.classes.update');

    Route::delete('/{id}', 'destroy')
        ->name('admin.classes.destroy');
});
