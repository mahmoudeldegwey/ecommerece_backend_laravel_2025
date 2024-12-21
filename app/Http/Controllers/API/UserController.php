<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController
{

    public function index(Request $request)
    {
        return auth('sanctum')->user();
    }
}
