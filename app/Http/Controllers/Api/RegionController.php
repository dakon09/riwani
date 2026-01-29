<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\Village;

class RegionController extends Controller
{
    public function provinces(Request $request)
    {
        $search = $request->q;
        $data = Province::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })->get();

        return response()->json($data);
    }

    public function cities(Request $request, $provinceId)
    {
        $search = $request->q;
        $data = City::where('province_code', $provinceId)
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })->get();

        return response()->json($data);
    }

    public function districts(Request $request, $cityId)
    {
        $search = $request->q;
        $data = District::where('city_code', $cityId)
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })->get();

        return response()->json($data);
    }

    public function villages(Request $request, $districtId)
    {
        $search = $request->q;
        $data = Village::where('district_code', $districtId)
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })->get();

        return response()->json($data);
    }
}
