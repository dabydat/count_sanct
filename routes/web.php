<?php

use App\Http\Controllers\StudentsController;
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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::controller(StudentsController::class)->group(function () {
        Route::name('students.')->group(function () {
            Route::get('/students', 'index')->name('index');
            Route::post('/studentsList', 'list')->name('list');
            Route::get('/students/create', 'create')->name('create');
            Route::post('/students/store', 'store')->name('store');
        });
    });
});