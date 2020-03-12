<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('website_id');
            $table->unsignedBigInteger('gear_id');
            $table->string('price');
            $table->timestamps();

            $table->foreign('gear_id')->references('id')->on('gears');
            $table->foreign('website_id')->references('id')->on('websites');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prices');
    }
}
