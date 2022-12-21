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
        Schema::create('doctors_treatments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctorsId');
            $table->unsignedBigInteger('treatmentsId');

            $table->foreign('doctorsId')->references('id')->on('doctors');
            $table->foreign('treatmentsId')->references('id')->on('treatments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctors_treatments');
    }
};
