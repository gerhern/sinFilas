<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    //
    public function getTransactionsByOffice(Request $request){
        try{
            $idOffice = $request->office;
            if(isset($idOffice)){
                $office = Office::where('id', '=', $idOffice)->withCount('transactions')->first();

                if(!isset($office)){
                    throw new \Exception("Oficina no valida", 404);
                }

                if($office->transactions_count <= 0){
                    throw new \Exception("No existen tramites asignados a esta oficina", 404);
                }
                $response = $office->transactions;

            }else{
                $response = Office::with('transactions')->get();
            }

                return [
                    'success'   =>  true,
                    'message'   =>  '',
                    'data'      =>  json_decode($response),
                    'error'     =>  '',
                    'code'      =>  200
                ];
        }catch(\Exception $e){
            return [
                'success'   =>  false,
                'message'   =>  'Error al consultar tramites',
                'data'      =>  '',
                'error'     =>  $e->getMessage(),
                'code'      =>  $e->getCode()
            ];
        }
    }
}
