<?php

use App\Http\Controllers\REgridController;

use Illuminate\Support\Facades\Route;

/*
* Custom Fields Routes
*/

Route::group(['middleware' => 'auth'], function () {
Route::controller(REgridController::class)->group(function () {
    Route::get('/re_expense', 'show')->name('re_expense');
    Route::get(
        're_expense/export',
        [REgridController::class, 'export']
    )->name('re_expense.export');   
});


Route::get('/approve/{id}', [  App\Http\Controllers\Api\REgridController::class, 'approval'])->name('expence.approval');
Route::get('/disapprove/{id}', [  App\Http\Controllers\Api\REgridController::class, 'disapproval'])->name('expence.disapproval');

});