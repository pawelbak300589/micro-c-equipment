<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGearUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gear_urls', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('website_id');
            $table->unsignedBigInteger('gear_id');
            $table->string('url');
            $table->boolean('main')->default(0);
            $table->timestamps();

            $table->foreign('website_id')->references('id')->on('websites');
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
        Schema::dropIfExists('gear_urls');
    }
}
