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

class AppointmentController extends Controller{


    public function addAppointment(Request $request)
    {
        try {
            $userId = auth()->user()->id;
            //$doctorId= doctor()-> doctorId;
            $date = $request->input('date');
            $duration = $request->input('duration');


            $newAppointment = new Appointment();
            $newAppointment->date = $date;
            $newAppointment->duration = $duration;
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

}