<?php

namespace App\Http\Controllers\Frontend\User;

use App\Models\City;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    public function getCityByName(Request $request)
    {
        $name = $request->name;
        $cities = City::where('name', 'like', '%' . $name . '%')
            ->orderBy('name')
            ->get();
        $result = [];
        foreach ($cities as $city) {
            $result [] = [
                'label' => $city->name,
                'id' => $city->id
            ];
        }

        return json_encode($result);
    }
}
