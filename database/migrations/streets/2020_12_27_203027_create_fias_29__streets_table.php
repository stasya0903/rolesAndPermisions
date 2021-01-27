<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFias29StreetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fias_29__streets', function (Blueprint $table) {
            $table->id();
            $table->string('aoid');
            $table->string('parentguid');
            $table->string('offname');
            $table->string('shortname');
            $table->string('regioncode');
            $table->string('okato');
            $table->string('oktmo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fias_29__streets');
    }
}