<?php

namespace App\Http\Controllers;

use App\Jobs\addToDbJob;
use App\Jobs\streetsJob;
use App\Models\ConstituentEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\AddressObject;


class TableSeparatorController extends Controller
{
    public function fillDistrictTable()
    {
        $allDistricts = AddressObject::select('aoid', 'offname', 'shortname', 'regioncode', 'okato', 'oktmo')
            ->where('aolevel', 3)
            ->where('livestatus', 1)
            ->where('actstatus', 1)
            ->get();
        $this->addToDB($allDistricts, 'districts');
    }

    public function fillStreetsTable()
    {
        $allStreets = AddressObject::select('aoid', 'offname', 'shortname', 'regioncode', 'parentguid', 'okato', 'oktmo')
            ->whereIn('aolevel', [7, 91])
            ->where('livestatus', 1)
            ->where('regioncode', '22')
            ->where('actstatus', 1)
            ->get();

        $tableName = 'fias_22__streets';

        foreach ($allStreets->chunk(500) as $chunk) {
           streetsJob::dispatch($chunk->toArray(), $tableName);
        }
        echo sizeof($allStreets) . "  <br/>  ";


    }

    public function fillCitiesTable()
    {

        $pages = 163764 / 500;

        for ($i = 0; $i < 634743; $i += 500) {
            addToDbJob::dispatch($i);
            //DB::table('cities')->insertOrIgnore($cities->toArray());
        }
    }

    public function addToDB($collection, $sourceTable)
    {
        foreach ($collection->chunk(500) as $chunk) {
            DB::table($sourceTable)->insertOrIgnore($chunk->toArray());
        }
    }
}
