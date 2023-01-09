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
            if (auth()->user()->role == 1){


                $name = $request->input('name');
                $especialidad = $request->input('especialidad');
               
                $newDoctor = new Doctor();
                $newDoctor->name = $name;
                $newDoctor->especialidad = $especialidad;
            
                $newDoctor->save();
    
                return response()->json([
                    "success" => true,
                    "message" => "Doctor created"
                ], 201);

            } else {
                return response()->json([

                    'succes' => false,
                    'message' => 'Admin is unic created doctors'
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
            if (auth()->user()->role == 1) {


                return response()->json([
                    'success' => true,
                    'message' => 'Doctors successfully retrieved',
                    'data' => $doctors
                ], 200);
            } else {
                return response()->json([

                    'succes' => false,
                    'message' => 'Admin is unic view alldoctors' 
                ], 400);
            }
        } catch (\Throwable $th) {
            Log::error("Error retrieving doctors: " . $th->getMessage());

            return response()->json([
                'success' => true,
                'message' => 'Doctors could not be retrieved'
            ], 500);
        }
    }

    public function deleteDoctor($id)
    {

        try {
            if (auth()->user()->role == 1){

                Doctor::where('id', $id)
                ->delete(['is_active' => false]);
                   
                return response([
                    'succes' => true,
                    'message' => 'Se ha borrado el doctor correctamente',
    
                ], 200);


            } else {
                return response()->json([

                    'succes' => false,
                    'message' => 'Admin is unic delete doctor'
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