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
        

                return response()->json([
                    'success' => true,
                    'message' => 'Usuarios recuperados con éxito',
                    'data' => $users
                ], 200);
       
        } catch (\Throwable $th) {
            Log::error("Error retrieving users: " . $th->getMessage());

            return response()->json([
                'success' => true,
                'message' => 'Los usuarios no pudieron ser recuperados'
            ], 500);
        }
    }


    public function appointments()
    {
        try {
            $appointments = Appointment::get();

            return response()->json([
                'succes' => true,
                'message' => 'Citas recuperadas con éxito',
                'data' => $appointments
            ], 200);
        } catch (\Throwable $th) {

            Log::error("Error retrieving users: " . $th->getMessage());

            return response()->json([
                'succes' => true,
                'message' => 'No se pudieron recuperar las citas' . $th->getMessage()
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
