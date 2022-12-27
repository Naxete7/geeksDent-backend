<?php

namespace App\Http\Controllers;


use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
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
            $userId = auth()->user()->id;
            //$doctorId= doctor()-> doctorId;
            $date = $request->input('date');
            $duration = $request->input('duration');
            $description = $request->input('description');


            $newAppointment = new Appointment();
            $newAppointment->date = $date;
            $newAppointment->duration = $duration;
            $newAppointment->description = $description;
            $newAppointment->usersId = $userId;
            //$newAppointment->doctorssId = $doctorId;
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

    public function myAppointments()
    {
        try {
            $userId = auth()->user()->id;
           

            $appointments = DB::table('appointments')
            ->join('appointments','userId','=','appointment.userId')
            ->select('users.*','date')
            ->get();

            return response()->json([
                "succes" => true,
                "message" => "Get appointments succesfully",
                "data" => $appointments
            ], 200);
        } catch (\Throwable $th) {

            return response()->json([
                "succes" => false,
                "message" => "Error getting appointments" . $th->getMessage()
            ], 500);
        }
    }

    //public function myAppointments()
    //{
    //    try {
    //        $userId = auth()->user()->id;
    //        $user=User::find($userId);

    //        $myAppointments = $user->appointments()->get();

    //        if (auth()->user()->role == 2) {
    //            return response()->json([
    //                'succes' => true,
    //                'message' => 'Appointments succesfully retrieved',
    //                'data' => $myAppointments
    //            ], 200);
    //        } else {
    //            return response()->json([
    //                'succes' => false,
    //                'message' => 'Admin is unic wiew all appointments'
    //            ], 400);
    //        }
    //    } catch (\Throwable $th) {

    //        Log::error("Error retrieving users: " . $th->getMessage());

    //        return response()->json([
    //            'succes' => true,
    //            'message' => 'Appointments could not be retrieved' . $th->getMessage()
    //        ], 500);
    //    }
    //}



    //public function myAppointments($userId)
    //{
    //    try {
    //        $appointments = Appointment::where("user_id", "=", $userId)->select('id as _id','date', 'description', 'user_id as userId')->get();
    //        return response()->json($appointments);
    //    } catch (\Illuminate\Database\QueryException $e) {

    //        return response()->json([
    //            'error' => "no se encontro ningun resultado",
    //            'errorCode' => "mostrar_cita_1"
    //        ], 500);
    //    }
    //}
}