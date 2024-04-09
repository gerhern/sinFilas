<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//Inicio de rutas api
Route::prefix('v1')->group(function(){
    Route::get('index', function(Request $request){
        return 'Hello world-api';
    });
});
//fin de rutas api
