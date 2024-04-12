<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Transaction;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    //
    public function getOfficesByTransaction(Request $request){
        try{
            $idTransaction = $request->transaction;
            if(isset($idTransaction)){
                $transaction = Transaction::where('id', '=', $idTransaction)->withCount('offices')->first();

                if(!isset($transaction)){
                    throw new \Exception("Tramite no valido", 404);
                }

                if($transaction->offices_count <= 0){
                    throw new \Exception("No existen oficinas relacionadas a este tramite", 404);
                }

                $response = $transaction->offices;

            }else{
                $response = Office::get();
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
                'message'   =>  'Error al consultar oficinas',
                'data'      =>  '',
                'error'     =>  $e->getMessage(),
                'code'      =>  $e->getCode()
            ];
        }
    }
}
