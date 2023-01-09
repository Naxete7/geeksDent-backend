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
                

                $newTreatment->save();

                return response()->json([
                    "success" => true,
                    "message" => "Treatment created"
                ], 201);
            } else {
                return response()->json([

                    'succes' => false,
                    'message' => 'Admin is unic created treatments'
                ], 400);
            }
        } catch (\Throwable $th) {
            Log::error('Error creating treatment: ' . $th->getMessage());

            return response()->json([
                "success" => false,
                "message" => "Error creating treatment" . $th->getMessage()
            ], 201);
        }
    }






    public function treatments()
    {
        try {
            $treatments = Treatment::get();
            if (auth()->user()->role == 1) {


                return response()->json([
                    'success' => true,
                    'message' => 'Treatments successfully retrieved',
                    'data' => $treatments
                ], 200);
            } else {
                return response()->json([

                    'succes' => false,
                    'message' => 'Admin is unic view all treatments'
                ], 400);
            }
        } catch (\Throwable $th) {
            Log::error("Error retrieving treatments: " . $th->getMessage());

            return response()->json([
                'success' => true,
                'message' => 'Treatments could not be retrieved'
            ], 500);
        }
    }
}
