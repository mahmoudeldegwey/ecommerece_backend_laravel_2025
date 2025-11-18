<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
    	try {
		
		    $user = User::where('email', $request->email)->first();
		 
		    if (! $user || ! Hash::check($request->password, $user->password)) {
		        throw ValidationException::withMessages([
		            'email' => ['The provided credentials are incorrect.'],
		        ]);
		    }
		     		
    	} catch (\Exception $e) {
    		return response()->json(['error' => true,'message' => $e->getMessage()]);
    	}

	    return response()->json(['error' => false,'data' => [
	    	'user' => $user, ...['token' => $user->createToken($request->email)->plainTextToken]
	    ]]);
    }

    public function getUser(Request $request){
    	return new UserResource($request->user());
    	return ['data' => ['user' => auth('sanctum')->user() , 'token' => auth('sanctum')->user()->createToken('email')->plainTextToken ]];
    }

    public function logout(){
    	return auth('sanctum')->user()->tokens()->delete();
    }
}
