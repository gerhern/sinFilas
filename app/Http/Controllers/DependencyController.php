<?php

namespace App\Http\Controllers;

use App\Models\Dependency;
use Illuminate\Http\Request;

class DependencyController extends Controller
{
    //
    public function getDependenciesList(Request $request){
        try{
            $idDependency = $request->dependency;
            if(!isset($idDependency)){
                $data = Dependency::orderBy('name', 'asc')->get();
            }else{
                $data = Dependency::find($idDependency);
            }
            if(!$data){
                throw new \Exception("No se encontraron datos", 404);
            }

            return [
                'success'   =>  true,
                'message'   =>  'Dependencias obtenidas correctamente',
                'data'      =>  json_decode($data),
                'error'     =>  '',
                'code'      =>  200
            ];
        }catch(\Exception $e){
            return [
                'success'   =>  false,
                'message'   =>  'Error al obtener dependencias',
                'data'      =>  '',
                'error'     =>  $e->getMessage(),
                'code'      =>  $e->getCode()
            ];
        }
    }
}
