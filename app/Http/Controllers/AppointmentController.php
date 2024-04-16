<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Transaction;
use App\Traits\DatesTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    //
    use DatesTrait;

    public function makeAppointment(Request $request){
        try {
            $office = $request->officeId;
            $timeStamp = $request->timeStamp;
            $transaction = $request->transactionId;

            $appointmentTimeStamp = Carbon::createFromFormat('Y-m-d H:i:s', $timeStamp);
            $appointmentYear = $appointmentTimeStamp->year;
            $appointmentMonth = $appointmentTimeStamp->month;
            $appointmentDay = $appointmentTimeStamp->day;

            $appointmentHour = $appointmentTimeStamp->hour;
            $appointmentMinutes = $appointmentTimeStamp->minute;

            $this->getMaxTimeForTransactionOffice($office);

            //Validar si la fecha y hora no estan apartadas

        }catch (\Exception $e){
            return $e->getMessage();
        }
//        DB::beginTransaction();
//        try {

//            //obtener horas disponibles del dia
//            $horasdisponibles=self::getavailablehours(intval($oficina["value"]),intval($tramite["value"]),$dia,$mes,$anio);
//            $data 			= $horasdisponibles->getData();
//            //obtener horarios y horaejecucion
//            $horaejecucion  = $data->horaejecucion;
//            $horarios 		= (array) $data->horas[0]->horarios;
//            $disponible = 0;
//            //validamos si la hora seleccionada sigue dentro de las horas disponibles, si se encuentra se marca como 1
//            foreach($horarios as $elementey => $element){
//                if($elementey==$hora){
//                    $disponible=1;
//                }
//            }
//            //si esta disponible (disponible mayor a 0)
//            if($disponible>0){
//                $folio = self::gen_uuid();
//                $holdingcita= new Holdingcita();
//                $holdingcita->oficina_id	= $oficina["value"];
//                $holdingcita->fechahora 	= $fechahora["value"].":00";
//                $holdingcita->folio 		= $folio;
//                $holdingcita->save();
//
//                $errorboolean="false";
//                $description="<k>Fecha/hora reservada con éxito</k>";
//                DB::commit();
//            }else{
//                $holdingcita=[];
//                $errorboolean="true";
//                $description="<k>La fecha/hora ya fue reservada por alguien más a ".$horaejecucion.". Intenta con otra fecha/hora.</k>";
//            }
//
//        } catch (Exception $e) {
//            DB::rollback();
//            $holdingcita=[];
//            $errorboolean="true";
//            $description="Ocurrió un error en la base de datos, intenta más tarde. ".$e;
//
//        }
//        return response()->json([
//            'error' => $errorboolean,
//            'description' => $description,
//            'holdingcita' => $holdingcita
//        ]);
    }

    public function getAppointmentsByDay(Request $request){
        try{
            $timeStamp = $request->date;
            $date = Carbon::createFromFormat('Y-m-d', $timeStamp);

            $appointments = Appointment::whereDate('date', $date)
                ->where('appointment_status', 'Activa')
                ->orderBy('date', 'asc')
                ->get();

            return [
                'success'   =>  true,
                'message'   =>  '',
                'data'      =>  json_decode($appointments),
                'error'     =>  '',
                'code'      =>  200
            ];
        }catch(\Exception $e){
            return [
                'success'   =>  false,
                'message'   =>  'Error al obtener las citas del dia',
                'data'      =>  '',
                'error'     =>  $e->getMessage(),
                'code'      =>  $e->getCode()
            ];
        }
    }

    public function getAppointmentsByRange(Request $request){
        try{
            $startDate = $request->startDate;
            $endDate = $request->endDate;
            $startDate = Carbon::createFromFormat('Y-m-d', $startDate);
            $endDate = Carbon::createFromFormat('Y-m-d', $endDate);

            $appointments = Appointment::whereDate('date', '>=',  $startDate)
                ->whereDate('date', '<=', $endDate)
                ->where('appointment_status', 'Activa')
                ->orderBy('date', 'asc')
                ->get();

            return [
                'success'   =>  true,
                'message'   =>  '',
                'data'      =>  json_decode($appointments),
                'error'     =>  '',
                'code'      =>  200
            ];
        }catch(\Exception $e){
            return [
                'success'   =>  false,
                'message'   =>  'Error al obtener las citas del dia',
                'data'      =>  '',
                'error'     =>  $e->getMessage(),
                'code'      =>  $e->getCode()
            ];
        }
    }

    public function getAppointmentByFolio(Request $request){
        $folio = $request->folio;
        $appointment = Appointment::where('folio', '=', $folio)->with('transaction')->first();
    }

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
