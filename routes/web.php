<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\StudentController;


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

Route::get('/',function (){
    return view('welcome');
});

Auth::routes();

Route::group(['prefix' => 'admin','middleware' => ['auth','is_admin']], function() {
    Route::get('dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('students', [StudentController::class, 'index'])->name('admin.students');
    Route::get('/student/create', [StudentController::class, 'create'])->name('admin.student.create');
    Route::post('/student/store', [StudentController::class, 'store'])->name('admin.student.store');
    Route::post('/student/update/{id}', [StudentController::class, 'update'])->name('admin.student.update');
    Route::get('/student/edit/{id}', [StudentController::class, 'edit'])->name('admin.student.edit');

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
