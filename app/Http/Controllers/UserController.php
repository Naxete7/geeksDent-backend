<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{


     public function getAllUsers()
    {
        try {
            $users = User::get();
if(auth()->user()->userRol === 1) {


    return response()->json([
        'success' => true,
        'message' => 'Users successfully retrieved',
        'data' => $users
    ]);
} else {
    return response()->json([

        'succes'=>false,
        'message'=>'Admin is unic view all profile'
    ],400);
}
        } catch (\Throwable $th) {
            Log::error("Error retrieving users: " . $th->getMessage());

            return response()->json([
                'success' => true,
                'message' => 'Users could not be retrieved'
            ], 500);
        }
    }

    public function updateUser(Request $request)
    {
        try {

            $userId = auth()->user()->id;
           

            $validator = Validator::make($request->all(), [
                
                'name' => 'string|max:255',
                'surname' => 'string|max:255',
                'phone' => 'string|min:8',
                'birth_date' => 'date',
                
            ]);

            if ($validator->fails()) {
                return response([
                    'success' => false,
                    'message' => $validator->messages()
                ], 400);
            }

            $user = User::find($userId);
            $user->name = $request->input('name');
            $user->surname = $request->input('surname');
            $user->phone = $request->input('phone');
            $user->birth_date = $request->input('birth_date');
            $user->save();

            return response([
                'success' => true,
                'message' => 'Player data modified correctly.'
            ], 200);

        } catch (\Throwable $th) {
            //Log::error($th->getMessage());
            return response([
                'success' => false,
                'message' => 'Error when modifying player data' . $th->getMessage()
            ], 500);
        }

    }

    



}
