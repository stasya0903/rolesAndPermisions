<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\AddressObject;

class addToDbJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $citiesArray;
    private $offset;

    /**
     * Create a new job instance.
     *
     * @param $citiesArray
     */
    public function __construct($ofset)
    {
        $this->offset = $ofset;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $cities = AddressObject::select('aoid', 'offname', 'shortname', 'regioncode', 'okato', 'oktmo')
            ->whereIn('aolevel', [4, 6, 35])
            ->where('livestatus', 1)
            ->where('actstatus', 1)
            ->offset($this->offset)
            ->limit(500)
            ->get();
        DB::table('cities')->insertOrIgnore($cities->toArray());
    }
}
