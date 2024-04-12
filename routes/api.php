<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{AppointmentController, TransactionController, OfficeController};

//Inicio de rutas api
Route::prefix('v1')->group(function(){
    Route::get('home', function(Request $request){
        return 'Hello world-api';
    });

    //Appointments
    Route::post('cancelAppointment', [AppointmentController::class, 'cancelAppointment']);

    //Transactions
    Route::get('getTransactionsByOffice', [TransactionController::class, 'getTransactionsByOffice']);

    //Offices
    Route::get('getOfficesByTransaction', [OfficeController::class, 'getOfficesByTransaction']);
});
//fin de rutas api
