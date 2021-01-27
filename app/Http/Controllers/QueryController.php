<?php

namespace App\Http\Controllers;

use App\Models\ConstituentEntity;
use App\Models\FiasLevelCode;
use Illuminate\Http\Request;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\AddressObject;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\House;

class QueryController extends Controller
{
    public function getRegions()
    {
        $regions = ConstituentEntity::all();
        return response()->json($regions)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    public function getDistricts(Request $reguest, $fias_code)
    {
        $level = FiasLevelCode::query()->where('slug', 'district')->get()->first()->fias_code;
        $allDistricts = AddressObject::select('formalname', 'aoguid', 'areacode')
            ->where('actstatus', 1)
            ->where('regioncode', $fias_code)
            ->whereIn('aolevel', [$level])
            ->get();

        return response()->json($allDistricts)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    public function getCities(Request $reguest, $fias_code)
    {
        $allCities = AddressObject::select('formalname', 'aoguid', 'areacode', 'shortname')
            ->where('actstatus', 1)
            ->where('regioncode', $fias_code)
            ->whereIn('aolevel', [4, 35, 6])
            ->get();
        $allDistricts = AddressObject::select('formalname', 'aoguid', 'areacode', 'shortname')
            ->where('actstatus', 1)
            ->where('regioncode', $fias_code)
            ->where('aolevel', 3)
            ->get();

        $citiesUnique = $allCities->unique('formalname');
        $citiesDupies = $allCities->diffAssoc($citiesUnique);


        $keyed = $citiesDupies->map(function ($item) use ($allDistricts) {

            $areaCode = $item['areacode'];
            $area = $allDistricts->firstWhere('areacode', $areaCode);
            if ($area) {
                $areaName = "$area->formalname $area->shortname";
                $item->formalname = $item['formalname'] . " ($areaName)";

            }
                return $item;

        });

        $citiesUpdated = $citiesUnique->concat($keyed);
        return response()->json(array_values($citiesUpdated->toArray()))->setEncodingOptions(JSON_UNESCAPED_UNICODE);

    }


    public function getStreets(Request $reguest, $cityCode)
    {
        $allStreets = AddressObject::select('formalname')
            ->where('actstatus', 1)
            ->where('parentguid', $cityCode)
            ->whereIn('aolevel', [7])
            ->get();
        return response()->json($allStreets)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    public function getHouses($streetId)
    {
        $allHouses = House::select('housenum', 'strucnum', 'houseguid', 'buildnum')
            ->distinct()
            ->where('AOGUID', '=', $streetId)
            ->get();
        return response()->json($allHouses)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }
}
