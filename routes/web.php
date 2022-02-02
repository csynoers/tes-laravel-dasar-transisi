<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::group(['middleware' => 'auth'], function(){
//     Route::resource('company', CompanyController::class);
//     Route::resource('employee', EmployeeController::class);
    
//     // ajax
//     Route::get('ajax/company', [CompanyController::class, 'dataAjax']);
//     // export pdf
//     Route::post('employee/pdf', [EmployeeController::class, 'exportPdf'])->name('employee.pdf');
//     // import excel
//     Route::post('employee/import', [EmployeeController::class, 'importExcel'])->name('employee.import');
// });