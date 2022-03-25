<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validate = \Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->messages(),
            ]);
        }
        $user = User::where('email', $request->input('email'))->first();
        if ($user) {
            if (Hash::check($request->input('password'), $user->password)) {
                $prevToken = str_replace('Bearer ', '', $request->header('Authorization'));
                //return $prevToken;
                if ($user->api_token==$prevToken) {
                    $newToken=Str::random(60);
                    $user->update(['api_token'=>$newToken]);
                    return response()->json([
                        'name' => $user->name,
                        'access_token' => $newToken,
                        'time' => date('H:i:s'),
                    ], JsonResponse::HTTP_OK);
                }
                return response()->json([
                    'message' => 'Tokens Not Matched!',
                ], JsonResponse::HTTP_UNAUTHORIZED);
            }
            return response()->json([
                'message' => 'Wrong Password!',
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => 'User Not Found!'
        ], JsonResponse::HTTP_NOT_FOUND);

    }
}
