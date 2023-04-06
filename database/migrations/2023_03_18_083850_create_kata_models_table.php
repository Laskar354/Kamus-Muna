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
        Schema::create('kata_models', function (Blueprint $table) {
            $table->id();
            $table->string("kataIndo");
            $table->string("kataMuna");
            $table->string("jns_kata");
            $table->string("vSaya")->nullable();
            $table->string("vKami")->nullable();
            $table->string("vKamu")->nullable();
            $table->string("vDia")->nullable();
            $table->string("vMereka")->nullable();

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
        Schema::dropIfExists('kata_models');
    }
};
