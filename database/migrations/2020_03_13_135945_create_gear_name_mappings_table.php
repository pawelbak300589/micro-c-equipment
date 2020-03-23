<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGearNameMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gear_name_mappings', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('gear_id');
            $table->string('name');
            $table->timestamps();

            $table->foreign('gear_id')->references('id')->on('gears')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gear_name_mappings');
    }
}
