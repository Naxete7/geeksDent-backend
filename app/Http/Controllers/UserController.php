<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function updateUser(Request $request)
    {
        try {
            $userId = auth()->user()->id;
            $validator = Validator::make($request->all(), [
                'name' => 'string|max:255',
                'surname' => 'string|max:255',
                'phone' => 'string|min:8',
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
            $user->save();
            return response([
                'success' => true,
                'message' => 'Usuario modificado satisfactoriamente'
            ], 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response([
                'success' => false,
                'message' => 'Error cuando se estaba modificando el usuario'
            ], 500);
        };
    }
}
