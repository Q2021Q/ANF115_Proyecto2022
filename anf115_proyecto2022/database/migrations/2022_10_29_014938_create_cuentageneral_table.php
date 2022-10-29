<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuentageneralTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuentageneral', function (Blueprint $table) {
            $table->char('YEAR', 4);
            $table->char('IDEMPRESA', 10);
            $table->char('CODIGOCUENTA', 15);
            $table->integer('IDTIPOCUENTA')->index('FK_RELATIONSHIP_6');
            $table->integer('IDTIPOESTADOFINANCIERO')->nullable()->index('FK_REFERENCE_11');
            $table->decimal('SALDO', 12, 2);
            
            $table->primary(['YEAR', 'IDEMPRESA', 'CODIGOCUENTA']);
            $table->index(['IDEMPRESA', 'CODIGOCUENTA'], 'FK_RELATIONSHIP_10');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cuentageneral');
    }
}
