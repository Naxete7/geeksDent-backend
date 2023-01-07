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
            //$email =  $request->get('email');
            //$userIsCreate = User::where('email', $email)
            //    ->where('is_active', false)
            //    ->get()
            //    ->toArray();

            //$userExist = User::where('email', $email)
            //    ->where('is_active', true)
            //    ->get()
            //    ->toArray();

            //if (count($userExist) === 1) {
            //    return response()->json([
            //        "success" => false,
            //        "message" => 'Este email ya había sido utilizado.'
            //    ], 200);
            //}
            //if (count($userIsCreate) === 1) {
            //    $user = User::query()
            //        ->where('email', $email)

            //        ->update(['is_active' => true]);

            //    return response()->json([
            //        "success" => false,
            //        "message" => 'Este email ya había sido utilizado, por lo tanto, hemos reactivado la cuenta.'
            //    ], 200);
            //}

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|min:8',
            'birth_date'=>'string'
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
