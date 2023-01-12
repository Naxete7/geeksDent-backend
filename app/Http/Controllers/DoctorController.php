<?php

namespace App\Http\Controllers;


use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class DoctorController extends Controller
{

    public function addDoctor(Request $request)
    {
        try {
            if (auth()->user()->role == 1) {


                $name = $request->input('name');
                $especialidad = $request->input('especialidad');

                $newDoctor = new Doctor();
                $newDoctor->name = $name;
                $newDoctor->especialidad = $especialidad;
                $newDoctor->active = true;

                $newDoctor->save();

                return response()->json([
                    "success" => true,
                    "message" => "Doctor creado"
                ], 201);
            } else {
                return response()->json([

                    'succes' => false,
                    'message' => 'El admin es el unico que puede crear doctores'
                ], 400);
            }
        } catch (\Throwable $th) {
            Log::error('Error creating doctor: ' . $th->getMessage());

            return response()->json([
                "success" => false,
                "message" => "Error creating doctor" . $th->getMessage()
            ], 201);
        }
    }
    public function doctors()
    {
       
        try {
            
            $doctors = Doctor::get();

            return response()->json([
                "succes" => true,
                "message" => "Doctores recuperados satisfactoriamente",
                "data" => $doctors
            ], 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json([
                "succes" => false,
                "message" => "Error al recuperar los doctores"
            ], 500);
        }
    }
    //public function doctors()
    //{
    //    try {
    //        $doctors = Doctor::get();
    //        {


    //            return response()->json([
    //                'success' => true,
    //                'message' => 'Doctores recuperados con exito',
    //                'data' => $doctors
    //            ], 200);
    //        } 
    //        }
    //    } catch (\Throwable $th) {
    //        Log::error("Error retrieving doctors: " . $th->getMessage());

    //        return response()->json([
    //            'success' => true,
    //            'message' => 'Los doctores no se han podido recuperar'
    //        ], 500);
    //    }
    //}

    public function deleteDoctor($id)
    {

        try {
            if (auth()->user()->role == 1) {

                Doctor::where('id', $id)
                    ->update(['active' => false]);

                return response([
                    'succes' => true,
                    'message' => 'Se ha borrado el doctor correctamente',

                ], 200);
            } else {
                return response()->json([

                    'succes' => false,
                    'message' => 'Admin es el unico que puede borrar doctores'
                ], 400);
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response([
                'succes' => false,
                'message' => 'No se ha podido borrar el doctor'
            ], 500);
        }
    }
}
