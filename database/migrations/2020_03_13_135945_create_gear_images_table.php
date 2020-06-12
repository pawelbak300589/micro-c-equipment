<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGearImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gear_images', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('gear_id');
            $table->string('src');
            $table->string('alt');
            $table->boolean('main')->default(0);
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
        Schema::dropIfExists('gear_images');
    }
}
