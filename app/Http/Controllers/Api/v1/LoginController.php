<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function getToken(LoginRequest $request)
    {
        // Consult the user via email
        $user = User::where('email', $request->email)->first();
        if(!isset($user)){
            return response([
                'message' => 'The email entered is not registered.'
            ], Response::HTTP_CONFLICT);
        }

        // Validate the password with hash()
        if(!Hash::check($request->password, $user->password)){
            return response([
                'message' => 'The password entered is not correct.'
            ], Response::HTTP_CONFLICT);
        }

        return $user->createToken("token-user-" . $user->id . "-". time())->plainTextToken;
    }

}
