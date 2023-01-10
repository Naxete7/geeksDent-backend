<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{

    public function users()
    {
        try {
            $users = User::get();
            if (auth()->user()->role == 1) {


                return response()->json([
                    'success' => true,
                    'message' => 'Users successfully retrieved',
                    'data' => $users
                ], 200);
            } else {
                return response()->json([

                    'succes' => false,
                    'message' => 'Admin is unic view all profile' 
                ], 400);
            }
        } catch (\Throwable $th) {
            Log::error("Error retrieving users: " . $th->getMessage());

            return response()->json([
                'success' => true,
                'message' => 'Users could not be retrieved'
            ], 500);
        }
    }


    public function appointments()
    {
        try {
            $appointments = Appointment::get();
            if
            (auth()->user()->role == 1) {
                return response()->json([
                    'succes' => true,
                    'message' => 'Appointments succesfully retrieved',
                    'data' => $appointments
                ], 200);
            } else {
                return response()->json([
                    'succes' => false,
                    'message' => 'Admin is unic wiew all appointments'
                ], 400);
            }
        } catch (\Throwable $th) {

            Log::error("Error retrieving users: " . $th->getMessage());

            return response()->json([
                'succes' => true,
                'message' => 'Appointments could not be retrieved' . $th->getMessage()
            ], 500);
        }
    }


    public function deleteUser($id)
    {
        try {

            User::where('id', $id)
                ->update(['active' => false]);

            return response([
                'success' => true,
                'message' => 'Se ha eliminado el ususario correctamente.'

            ], 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response([
                'success' => false,
                'message' => 'No se ha podido eliminar el ususario.'
            ], 500);
        }
    }

}
