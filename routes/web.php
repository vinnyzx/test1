<?php

use Illuminate\Support\Facades\Route;

// Client
Route::get('/', function () {
    return view('welcome');
});





// Admin
Route::prefix('admin')->name('admin.')->group(function () {


    Route::get('/', function () {
        return view('admin.dashboard.index');
    })->name('dashboard');

    Route::prefix('vouchers')->name('vouchers.')->group(function(){
        Route::get('/',function(){
            return view('admin.vouchers.index');
        })->name('index');
    });

});
