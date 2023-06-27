<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('type_id')->unsigned()->nullable();
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('type_brand_id')->unsigned()->nullable();
            $table->foreign('type_brand_id')->references('id')->on('type_brands')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('brand_model_id')->unsigned()->nullable();
            $table->foreign('brand_model_id')->references('id')->on('brand_models')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('model_capacity_id')->unsigned()->nullable();
            $table->foreign('model_capacity_id')->references('id')->on('model_capacities')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('status')->default(true)->index();
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
        Schema::dropIfExists('products');
    }
};
