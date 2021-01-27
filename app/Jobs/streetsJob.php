<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class streetsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $allStreets;
    private $tableName;

    /**
     * Create a new job instance.
     *
     * @param $allStreets
     * @param $tableName
     */
    public function __construct($allStreets, $tableName)
    {
        $this->allStreets = $allStreets;
        $this->tableName = $tableName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::table($this->tableName)->insertOrIgnore( $this->allStreets);
    }
}
