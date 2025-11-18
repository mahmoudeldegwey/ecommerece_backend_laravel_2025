<?php
namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Requests\Website\{LoginRequest,RegisterRequest};
use App\Models\Client;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\ClientResource;
use App\Http\Services\ClientService;

class AuthController extends Controller
{
	public function __construct(private ClientService $service)
    {
    }

    public function login(LoginRequest $request)
    {
    	try {
		
		    $client = Client::where('email', $request->email)->first();
		 
		    if (! $client || ! Hash::check($request->password, $client->password)) {
		        throw ValidationException::withMessages([
		            'email' => ['The provided credentials are incorrect.'],
		        ]);
		    }
		     		
    	} catch (\Exception $e) {
    		return response()->json(['error' => true,'message' => $e->getMessage()]);
    	}

	    return response()->json(['error' => false,'data' => [ 
	    	'client' => $client, ...['token' => $client->createToken($request->email)->accessToken]
	    ]]);
    }

    public function register(RegisterRequest $request)
    {
    	try {
		 
		    $client = $this->service->store($request);
		     		
    	} catch (\Exception $e) {
    		return response()->json(['error' => true,'message' => $e->getMessage()]);
    	}

	    return response()->json(['error' => false,'data' => [ 
	    	'client' => $client, ...['token' => $client->createToken($request->email)->accessToken]
	    ]]);
    }

    public function getClient(Request $request){
    	return new ClientResource(auth()->user());
    	return ['data' => ['client' => auth()->user() , 'token' => auth()->user()->createToken('email') ]];
    }

    public function logout(){
    	return auth()->user()->tokens()->delete();
    }
}
