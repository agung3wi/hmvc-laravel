<?php

use Illuminate\Support\Facades\Route;

Route::get("/login", 'AuthController@login')->name("login");
Route::get("/logout", 'AuthController@logout')->name("logout");

Route::post("/login", 'AuthController@actionLogin')->name("actionLogin");

Route::middleware("auth")->group(function () {
    Route::get("/", 'AuthController@home')->name("home");
});
