<?php
namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Traits\ResponsesTrait;
use Illuminate\Http\JsonResponse ;
use App\Http\Resources\CountryResource;

class CountryController extends Controller
{
    use ResponsesTrait;

    /**
     * Check coupon code is valid.
     */
    public function index(Request $request)
    {
        try {

            $data = Country::query()->paginate(10);
            
        } catch (Exception $e) {
            return $this->makeResponseErrors($e->getMessage());
        }

        return CountryResource::collection($data);

    }

    public function show(Request $request){
        $default_country = setting('default_country');

        $country_id = $request->country_id ?? $default_country;
        
        $country = Country::find($country_id);

        return new CountryResource($country);
    }

    
}
