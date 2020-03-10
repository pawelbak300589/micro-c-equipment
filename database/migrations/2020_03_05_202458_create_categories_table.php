<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('website_id');
            $table->string('name');
            $table->string('url');
            $table->timestamps();

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
        Schema::dropIfExists('categories');
    }
}
