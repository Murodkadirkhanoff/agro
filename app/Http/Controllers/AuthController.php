<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request){

        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }
       

        if (!Auth::attempt($request->only('email', 'password'))) {
               return response()->json([
                'message' => 'Login information is invalid.'
              ], 401);
        }
 
        $user = User::where('email', $request['email'])->firstOrFail();
                $token = $user->createToken('authToken')->plainTextToken;
 
            return response()->json([
              'access_token' => $token,
              'token_type' => 'Bearer',
            ]);
        }
}
