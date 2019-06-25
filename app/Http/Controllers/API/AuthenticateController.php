<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Access\Facades\Access;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Access\User\User;
use Illuminate\Support\Facades\Log;

use App\Http\Requests;

class AuthenticateController extends Controller
{
    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        $this->middleware('jwt.auth', ['except' => ['authenticate']]);
    }

    public function index()
    {
        // Retrieve all the users in the database and return them
        //$users = User::all();
        return true;
    }


    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                Log::notice('[Tablette] Invalid credentials: '. $credentials['email']);
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong

            Log::error('[Tablette] Could not create token: '. $credentials['email'] );
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        Log::info('[Tablette] User Logged In: '. Access::user()->name);

        // if no errors are encountered we can return a JWT
        return response()->json(compact('token'));
    }

}
