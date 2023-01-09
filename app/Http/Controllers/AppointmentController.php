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
            $duration = $request->input('duration');
            $reason = $request->input('reason');
            $userId = auth()->user()->id;
            $doctorId= doctors()-> id;
            $treatmentId=treatments()->id;


            $newAppointment = new Appointment();
            $newAppointment->date = $date;
            $newAppointment->duration = $duration;
            $newAppointment->reason = $reason;
            $newAppointment->usersId = $userId;
            $newAppointment->doctorssId = $doctorId;
            $newAppointment->treatmentId=$treatmentId;
            $newAppointment->save();

            return response()->json([
                "success" => true,
                "message" => "Appointment created"
            ], 201);
        } catch (\Throwable $th) {
            Log::error('Error creating appointment: ' . $th->getMessage());

            return response()->json([
                "success" => false,
                "message" => "Error creating Appointment" . $th->getMessage()
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
                    "message"=>"Appointment doesnt exists"
                ],404);
            }

            return response()->json([
                "success" => true,
                "message" => "Appointment updated"
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "Error updating Appointment"
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
                'message' => 'Se ha cencelado la reserva correctamente',

            ], 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response([
                'succes' => false,
                'message' => 'No se ha podido cancelar la reserva'
            ], 500);
        }
    }


}
