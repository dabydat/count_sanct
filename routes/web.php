<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\StudentController;
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
    Route::controller(StudentController::class)->group(function () {
        Route::name('students.')->group(function () {
            Route::get('/students', 'index')->name('index');
            Route::post('/studentsList', 'list')->name('list');
            Route::get('/students/create', 'create')->name('create');
            Route::post('/students/store', 'store')->name('store');
            Route::get('/students/show/{id}', 'show')->name('show');
            Route::get('/students/edit/{id}', 'edit')->name('edit');
            Route::post('/students/update/{id}', 'update')->name('update');
            Route::patch('/students/changeStatus/{id}', 'changeStatus')->name('changeStatus');
        });
    });

    Route::controller(CategoryController::class)->group(function () {
        Route::name('categories.')->group(function () {
            Route::get('/categories', 'index')->name('index');
            Route::post('/categoriesList', 'list')->name('list');
            Route::get('/categories/create', 'create')->name('create');
            Route::post('/categories/store', 'store')->name('store');
            Route::get('/categories/show/{id}', 'show')->name('show');
            Route::get('/categories/edit/{id}', 'edit')->name('edit');
            Route::post('/categories/update/{id}', 'update')->name('update');
            Route::patch('/categories/changeStatus/{id}', 'changeStatus')->name('changeStatus');
        });
    });

    Route::controller(ContributionController::class)->group(function () {
        Route::name('contributions.')->group(function () {
            Route::get('/contributions', 'index')->name('index');
            Route::post('/contributionsList', 'list')->name('list');
            Route::post('/contributionsPerPeriodsList', 'contributionsPerPeriodsList')->name('contributionsPerPeriodsList');
            Route::post('/contributionsPerPeriodsReceivedList', 'contributionsPerPeriodsReceivedList')->name('contributionsPerPeriodsReceivedList');
            Route::post('/contributionsPerStudentPerPeriodsList', 'contributionsPerStudentPerPeriodsList')->name('contributionsPerStudentPerPeriodsList');
            Route::get('/contributions/create', 'create')->name('create');
            Route::post('/contributions/store', 'store')->name('store');
            Route::get('/contributions/show/{id}', 'show')->name('show');
            Route::get('/contributions/edit/{id}', 'edit')->name('edit');
            Route::post('/contributions/update/{id}', 'update')->name('update');
            Route::post('/contributions/export/', 'export')->name('export');
        });
    });

    Route::controller(PeriodController::class)->group(function () {
        Route::name('periods.')->group(function () {
            Route::get('/periods', 'index')->name('index');
            Route::post('/periodsList', 'list')->name('list');
            Route::get('/periods/create', 'create')->name('create');
            Route::post('/periods/store', 'store')->name('store');
            Route::get('/periods/show/{id}', 'show')->name('show');
            Route::get('/periods/edit/{id}', 'edit')->name('edit');
            Route::post('/periods/update/{id}', 'update')->name('update');
            Route::get('/getPeriods', 'getPeriods')->name('getPeriods');
        });
    });
});