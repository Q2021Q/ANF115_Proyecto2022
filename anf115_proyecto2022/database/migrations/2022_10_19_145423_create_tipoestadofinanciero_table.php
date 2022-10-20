<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoestadofinancieroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipoestadofinanciero', function (Blueprint $table) {
            $table->integer('IDTIPOESTADOFINANCIERO')->primary();
            $table->string('NOMBREESTADOFINANCIERO', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipoestadofinanciero');
    }
}
