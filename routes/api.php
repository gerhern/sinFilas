<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AppointmentController;

//Inicio de rutas api
Route::prefix('v1')->group(function(){
    Route::get('home', function(Request $request){
        return 'Hello world-api';
    });

    Route::post('cancelar-cita', [AppointmentController::class, 'cancelAppointment'])->name('cancelarCita');
});
//fin de rutas api
