<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    { 
        $email= $request->get('email');
        $userCreate=User::where('email', $email)
        ->where('active',false)
        ->get()
        ->toArray();

        $userExist = User::where('email', $email)
        ->where('active', true)
        ->get()
        ->toArray();

        if (count($userExist) === 1) {
            return response()->json([
                "success" => false,
                "message" => 'Este email ya había sido utilizado.'
            ], 200);
        }
        if (count($userCreate) === 1) {
            $user = User::query()
                ->where('email', $email)
                ->update(['active' => true]);


            return response()->json([
                "success" => false,
                "message" => 'Hemos reactivado la cuenta.'
            ], 200);
        }


        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:25',
            'surname' => 'required|string|max:50',
            'email' => 'required|string|email|max:50|unique:users',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|min:8',
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
            'active' => true,
            //'role_id' => 2

        ]);

        
        $token = JWTAuth::fromUser($user);
        return response()->json(compact('user', 'token'), 201);
    }

    public function login(Request $request)
    {
        
        $input = $request->only('email', 'password');
        $jwt_token = null;
       $email= $request->email;
       $password= $request -> password;


        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'success' => true,
            'token' => $jwt_token,
            'email'=> $email,
            //'password'=> $password,
           
        ]);
    }


    public function profile()
    {
        return response()->json(auth()->user());
    }

    public function logout()
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
