<?php

namespace App\Http\Controllers;

use App\Models\Dependency;
use App\Models\Office;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
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

    public function getOfficesByDependency(Request $request){
        try{
            $officeName = $request->office;
            $idDependency = $request->dependency;
            if(!isset($idDependency)){
                $data = Dependency::with('offices')->orderBy('name');
                if(isset($officeName)){
                    $data = Dependency::with('offices')->whereHas('offices',  function(Builder $query) use ($officeName){
                       $query->where('name', 'like', "%$officeName%");
                    })->orderBy('name');
                }
                $data = $data->get();

            }else{
                $data = Dependency::with('offices');
                if(isset($officeName)){
                    $data = Dependency::with('offices')->whereHas('offices',  function(Builder $query) use ($officeName){
                        $query->where('name', 'like', "%$officeName%");
                    });
                }
                $data = $data->find($idDependency);
            }

            if(!$data){
                throw new \Exception("No se encontraron datos", 404);
            }

            return [
                'success'   =>  true,
                'message'   =>  'Oficinas obtenidas correctamente',
                'data'      =>  json_decode($data),
                'error'     =>  '',
                'code'      =>  200
            ];
        }catch(\Exception $e){
            return [
                'success'   =>  false,
                'message'   =>  'Error al obtener oficinas',
                'data'      =>  '',
                'error'     =>  $e->getMessage(),
                'code'      =>  $e->getCode()
            ];
        }
    }
}
