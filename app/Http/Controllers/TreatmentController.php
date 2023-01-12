<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class TreatmentController extends Controller
{

    public function addTreatment(Request $request)
    {
        try {
            if (auth()->user()->role == 1) {


                $name = $request->input('name');
                

                $newTreatment = new Treatment();
                $newTreatment->name = $name;
                $newTreatment->active=true;

                $newTreatment->save();

                return response()->json([
                    "success" => true,
                    "message" => "Treatmento creado"
                ], 201);
            } else {
                return response()->json([

                    'succes' => false,
                    'message' => 'Admin es el único que puede crer tratamientos'
                ], 400);
            }
        } catch (\Throwable $th) {
            Log::error('Error creating treatment: ' . $th->getMessage());

            return response()->json([
                "success" => false,
                "message" => "Error al crear el tratamiento" . $th->getMessage()
            ], 201);
        }
    }






    public function treatments()
    {
        try {
            $treatments = Treatment::get();
           

                return response()->json([
                    'success' => true,
                    'message' => 'Tratamientos recuperados con éxito',
                    'data' => $treatments
                ], 200);
            
            
        } catch (\Throwable $th) {
            Log::error("Error al recuperar los tratamientos: " . $th->getMessage());

            return response()->json([
                'success' => true,
                'message' => 'No se pudieron recuperar los tratamientos.'
            ], 500);
        }
    }


    public function deleteTreatment($id)
    {

        try {
            if (auth()->user()->role == 1) {

                Treatment::where('id', $id)
                ->update(['active' => false]);

                return response([
                    'succes' => true,
                    'message' => 'Se ha borrado el tratamiento correctamente',

                ], 200);
            } else {
                return response()->json([

                    'succes' => false,
                    'message' => 'Admin es el único que puede borrar el tratamiento'
                ], 400);
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response([
                'succes' => false,
                'message' => 'No se ha podido borrar el tratamiento'
            ], 500);
        }
    }

}
