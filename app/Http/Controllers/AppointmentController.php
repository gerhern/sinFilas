<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    //
    public function cancelAppointment(Request $request){

        try{
            $folio = $request->folio;
            if(!isset($folio)){
                throw new \Exception('Ingrese un folio para continuar', 400);
            }
            DB::beginTransaction();
                $appointment = Appointment::where('folio', '=', $folio)->first();
                if($appointment == null){
                    throw new \Exception('Folio incorrecto', 400);
                }

                $appointment = Appointment::where('folio', '=', $folio)->where('appointment_status', '=', 'Activa')->first();
                if($appointment == null){
                    throw new \Exception('La cita ya se encuentra dada de baja', 400);
                }

                $appointment->update(['appointment_status' => 'Inactiva']);
                DB::commit();

            return [
                'success'   =>  true,
                'message'   =>  'La cita ha sido cancelada con exito',
                'data'      =>  '',
                'error'     =>  '',
                'code'      =>  200
            ];
        }catch(\Exception $e){
            DB::rollBack();
            return [
                'success'   =>  false,
                'message'   =>  'Error al cancelar cita',
                'data'      =>  '',
                'error'     =>  $e->getMessage(),
                'code'      =>  $e->getCode()
            ];

        }
//        $folio = $request->folio;
//
//        if($folio && strlen($folio)==8){//si recibimos folio
//            try{
//                $cita=Cita::where('folio',$folio)->first();
//                $cita->statuscita='cancelada';
//                $cita->save();
//                DB::commit();
//                //$request = new \Illuminate\Http\Request();
//                //$request->replace(['folio' => $folio]);
//                //return Route::post('getcita', array('uses' => 'AppController@getcita'));//redirect()->route('getcita'); //Redirect::back();
//                return Redirect()->route('getcita', ['folio'=>$folio]);//::back()->withInput();
//            }
//            catch (Exception $e) {
//                DB::rollback();
//                //$errorboolean="true";
//                //$description="Ocurrió un error en la base de datos, intenta más tarde. ".$e;
//            }
//        }
//        else{
//
//        }
    }
}
