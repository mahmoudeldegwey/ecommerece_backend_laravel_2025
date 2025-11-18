<?php
namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Traits\ResponsesTrait;
use Illuminate\Http\JsonResponse ;
use App\Http\Resources\CitiesResource;

class CityController extends Controller
{
    use ResponsesTrait;

    /**
     * Check coupon code is valid.
     */
    public function citiesByCountry(Request $request)
    {
        try {
            
            $default_country = setting('default_country');

            $country_id = $request->country_id ?? $default_country;

            $cities = City::where('country_id',$country_id)->get();
            
        } catch (Exception $e) {
            return $this->makeResponseErrors($e->getMessage());
        }

        return CitiesResource::collection($cities);

    }

    
}
