<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogo', function (Blueprint $table) {
            $table->char('IDEMPRESA', 10);
            $table->char('CODIGOCUENTA', 15);
            $table->integer('IDTIPOESTADOFINANCIERO')->index('FK_RELATIONSHIP_12');
            $table->string('NOMBRECUENTA', 50);
            
            $table->primary(['IDEMPRESA', 'CODIGOCUENTA']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalogo');
    }
}
