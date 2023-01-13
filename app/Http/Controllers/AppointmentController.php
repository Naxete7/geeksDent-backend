<?php

namespace App\Http\Controllers;


use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Symfony\Contracts\Service\Attribute\Required;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{


    public function addAppointment(Request $request)
    {
        try {
            $date = $request->input('date');
            $reason = $request->input('reason');
            $usersId = auth()->user()->id;
            $doctorsId= $request->input('doctorsId');
            $treatmentsId= $request->input('treatmentsId');


            $newAppointment = new Appointment();
            $newAppointment->date = $date;
            $newAppointment->reason = $reason;
            $newAppointment->usersId = $usersId;
            $newAppointment->doctorsId = $doctorsId;
            $newAppointment->treatmentsId=$treatmentsId;
            $newAppointment->save();

            return response()->json([
                "success" => true,
                "message" => "Cita creada"
            ], 201);
        } catch (\Throwable $th) {
            Log::error('Error al crear la cita: ' . $th->getMessage());

            return response()->json([
                "success" => false,
                "message" => "Error al crear la cita" . $th->getMessage()
            ], 201);
        }
    }

    public function myappointments()
    {
        try {

            $userId = auth()->user()->id;

            $appointments = DB::table('appointments')
                ->where('usersId', '=', $userId)
                ->get();

            if (auth()->user()->role == 2) {
                return response()->json([
                    'succes' => true,
                    'message' => 'Citas recuperadas con éxito',
                    'data' => $appointments
                ], 200);
            } else {
                return response()->json([
                    'succes' => false,
                    'message' => 'Admin es el único que puede ver todas las citas'
                ], 400);
            }
        } catch (\Throwable $th) {

            Log::error("Error retrieving users: " . $th->getMessage());

            return response()->json([
                'succes' => true,
                'message' => 'Las citas no se han podido recuperar' . $th->getMessage()
            ], 500);
        }
    }


    public function updateAppointment(Request $request, $id){

            try{
                $userId=auth()->user()->id;
                $newDate=$request->input('date');


                $updateAppointment= Appointment::where('user_id',$userId)
                ->where('id', $id)
            ->update([
                'date' => $newDate,
               
            ]);

            if(!$updateAppointment){
                return response()->json([
                    "succes"=>true,
                    "message"=>"La cita no existe"
                ],404);
            }

            return response()->json([
                "success" => true,
                "message" => "Cita modificada"
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "Error al modificar la cita"
            ], 500);
        }
    }




    public function deleteAppointment($id)
    {

        try {
            $userId = auth()->user()->id;
            Appointment::where('user_id', $userId)
                ->where('id', $id)
                ->update(['cancelled'=> true]);

            return response([
                'succes' => true,
                'message' => 'Se ha cencelado la cita correctamente',

            ], 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response([
                'succes' => false,
                'message' => 'No se ha podido cancelar la cita'
            ], 500);
        }
    }


}
