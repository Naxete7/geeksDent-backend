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
        Schema::create('appointments_treatments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appointmentsId');
            $table->unsignedBigInteger('treatmentsId');

            $table->foreign('appointmentsId')->references('id')->on('appointments');
            $table->foreign('treatmentsId')->references('id')->on('treatments');
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
        Schema::dropIfExists('appointments_treatments');
    }
};
