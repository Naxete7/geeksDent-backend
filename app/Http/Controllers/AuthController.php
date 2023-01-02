<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // Iremos añadiendo cada uno de los métodos
    //const USER_ROLE_ID = 2;

    public function register(Request $request)
    { try{
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|min:8',
            'birth_date'=>'date'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }
        $user = User::create([
            'name' => $request->get('name'),
            'surname' => $request->get('surname'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->password),
            'phone'=>$request->get('phone'),
            'birth_date'=>$request->get('birth_date')

        ]);

        //$user->roles()->attach(self::USER_ROLE_ID);
        $token = JWTAuth::fromUser($user);
        return response()->json(compact('user', 'token'), 201);
        }catch(\Throwable $th){

            return response([
                'success' => false,
                'message' => 'Failed to create a User' . $th->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try{

        $input = $request->only('email', 'password');
        $jwt_token = null;
        $validation = JWTAuth::attempt($input);
        dd($validation);
        if (!$validation) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password', 
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'success' => true,
            'message'=>"Logged is succesfully",
            'token' => $validation,
        ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to Login a User' . $th->getMessage()
            ], 500);
        }
    }

    public function profile()
    {
        return response()->json(auth()->user());
    }

    public function logout(Request $request)
    {
        
        try {
            auth()->logout();
            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out '
            ], 500);
        }
    }
}
