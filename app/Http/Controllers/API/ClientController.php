<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Client;
use App\Http\Services\ClientService;
use App\Http\Requests\{CreateClientRequest,UpdateClientRequest,UpdatePasswordRequest};
use App\Traits\ResponsesTrait;

class ClientController
{
    use ResponsesTrait;

    public function __construct(private ClientService $service)
    {
    }

    public function index(Request $request)
    {
        return $this->service->index($request);
    }

    public function store(CreateClientRequest $request)
    {
        try {
            
            $this->service->store($request); 

        } catch (Exception $e) {
            return $this->makeResponseErrors($e->getMessage());
        }
        
        return $this->makeResponseSuccessful();
    }

    public function show(Client $client){
        return $this->service->show($client);
    }

    public function update(Client $client,UpdateClientRequest $request)
    {
        return $this->service->update($client,$request);   
    }

    public function updatePassword(Client $client,UpdatePasswordRequest $request)
    {
        return $this->service->updatePassword($client,$request);
    }

    public function destroy(Client $client)
    {
        return $this->service->destroy($client);
    }
}
