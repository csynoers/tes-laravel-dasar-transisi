<?php

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

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function(){
    Route::resource('company', CompanyController::class);
    Route::resource('employee', EmployeeController::class);
    
    // ajax
    Route::get('ajax/company', [Modules\Transisi\Http\Controllers\CompanyController::class, 'dataAjax']);
    // export pdf
    Route::post('employee/pdf', [Modules\Transisi\Http\Controllers\EmployeeController::class, 'exportPdf'])->name('employee.pdf');
    // import excel
    Route::post('employee/import', [Modules\Transisi\Http\Controllers\EmployeeController::class, 'importExcel'])->name('employee.import');
});
