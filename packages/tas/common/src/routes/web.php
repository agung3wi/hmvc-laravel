<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::get("/login", 'AuthController@login')->name("login");
Route::get("/logout", 'AuthController@logout')->name("logout");

Route::post("/login", 'AuthController@actionLogin')->name("actionLogin");

Route::get("/assets/router.js", function () {
    $menu = App::make("routing")->menu;
    $content = view("common::router", ["menus" => $menu]);
    return response($content)
        ->header('Content-Type', 'text/javascript');
});

Route::middleware("auth")->group(function () {
    Route::get("/", 'AuthController@home')->name("home");
});
