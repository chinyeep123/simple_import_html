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
        Schema::create('model_capacities', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('brand_model_id')->unsigned()->nullable();
            $table->foreign('brand_model_id')->references('id')->on('brand_models')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name')->nullable()->index();
            $table->string('slug')->nullable()->index();
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
        Schema::dropIfExists('model_capacities');
    }
};
