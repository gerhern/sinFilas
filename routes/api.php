<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{AppointmentController, TransactionController, OfficeController, DependencyController};

//Inicio de rutas api
Route::prefix('v1')->group(function(){
    Route::get('home', function(Request $request){
        return 'Hello world-api';
    });

    //Appointments
    Route::get('getAppointmentsByDay', [AppointmentController::class, 'getAppointmentsByDay']);
    Route::get('getAppointmentsByRange', [AppointmentController::class, 'getAppointmentsByRange']);
//    Route::get('getAppointmentByFolio', [AppointmentController::class, 'getAppointmentByFolio']);
//    Route::post('makeAppointment', [AppointmentController::class, 'makeAppointment']);
    Route::post('cancelAppointment', [AppointmentController::class, 'cancelAppointment']);

    //Transactions
    Route::get('getTransactionsByOffice', [TransactionController::class, 'getTransactionsByOffice']);

    //Offices
    Route::get('getOfficesByTransaction', [OfficeController::class, 'getOfficesByTransaction']);
    Route::get('getOfficesByDependency', [OfficeController::class, 'getOfficesByDependency']);

    //Dependencies
    Route::get('getDependenciesList', [DependencyController::class, 'getDependenciesList']);
});
//fin de rutas api
