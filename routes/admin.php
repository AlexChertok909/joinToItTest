<?php

use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {

    Route::resource('companies', CompanyController::class);
    Route::resource('employees', EmployeeController::class);

});
