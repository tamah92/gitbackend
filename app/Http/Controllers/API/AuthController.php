<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    //
    public function register(Request $request) {
        $user = new User;
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->password = Hash::make($request->password);
        
        $user->save();
        return response()->json(
            [
                'data'      => $user,
                'message'   => "User added successfully.",
                'status'    => 200
            ],
            200
        );
    }

    public function login(Request $request) {
        try {
            $credentials = request(['email', 'password']);

        if(Auth::attempt($credentials)) {
            $getToken   = Auth::user()->createToken('APP_TOKEN');
            $token      = $getToken->token;
            $token->save();
            $user       = Auth::user();

            $data = User::with('usersettings', 'usersettings.usersettingscatagories')->where('id', $user->id)->first();
            return response()->json(
                [
                    'data'      => [
                        'token' => $getToken->accessToken,
                        'user' => $data,
                    ],
                    'message'   => "User login successfully.",
                    'status'    => 200
                ],
                200
            );

            // return $getToken->accessToken;
        } else {
            return response()->json(
                [
                    'data'      => (object) [],
                    'message'   => "Invalid Credentials.",
                    'status'    => 422
                ],
                422
            );
        }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(
                [
                    'data'      => (object) [],
                    'message'   => [
                        $th->getMessage(), $th->getLine()
                    ],
                    'status'    => 422
                ],
                422
            );
        }
        dd('hey');
    }
}
