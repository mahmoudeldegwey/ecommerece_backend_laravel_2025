<?php 
namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Filters\Client\{EmailFilter,UsernameFilter};
use Illuminate\Pipeline\Pipeline;
use App\Traits\ResponsesTrait;

class ClientService {

    use ResponsesTrait;
    
    public function __construct()
    {

    }

    public function index(Request $request){
        
        try {
            
            $paginate = $request->paginate ?? 10;

            $query = Client::query();

            $data = app(Pipeline::class)
            ->send($query)
            ->through([
                EmailFilter::class,
                UsernameFilter::class
            ])->thenReturn()->paginate($paginate);

        } catch (\Exception $e) {
           return $this->makeResponseErrors($e->getMessage());
        }

        return ClientResource::collection($data);
    }

    public function store(Request $request){
            
        $data = $request->except('password_confirmation');

        $data['password'] = Hash::make($request->password);
        
        return Client::create($data);

    }

    public function show(Client $client){
        try {
                
        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage());
        }

        return new ClientResource($client);
    }

    public function update(Client $client,Request $request)
    {
        try{

            $client = Client::where(['id' => $client->id])->update($request->all());

        }catch(\Exception $e){
            return $this->makeResponseErrors($e->getMessage());
        }

        return $this->makeResponseSuccessful();
    }

    public function updatePassword(Client $client,Request $request)
    {
        try{
            
            $request['password'] = Hash::make($request->password);
            
            $client = Client::where(['id' => $client->id])->update([
                'password' => $request->password,
            ]);

        }catch(\Exception $e){
            return $this->makeResponseErrors($e->getMessage());
        }

        return $this->makeResponseSuccessful();        
    }

    public function destroy(Client $client)
    {
        try {
            
            $client->delete();

        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage()); 
        }
        
        return $this->makeResponseSuccessful();
    }

}
