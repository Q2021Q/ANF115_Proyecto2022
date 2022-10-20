<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuentapuenteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuentapuente', function (Blueprint $table) {
            $table->char('CODCUENTARATIO', 4)->index('FK_RELATIONSHIP_11');
            $table->char('YEAR', 4);
            $table->char('IDEMPRESA', 10);
            $table->char('CODIGOCUENTA', 15);
            
            $table->index(['YEAR', 'IDEMPRESA', 'CODIGOCUENTA'], 'FK_RELATIONSHIP_13');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cuentapuente');
    }
}
