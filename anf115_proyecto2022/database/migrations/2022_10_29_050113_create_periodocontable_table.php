<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodocontableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodocontable', function (Blueprint $table) {
            $table->char('YEAR', 4);
            $table->char('IDEMPRESA', 10)->index('FK_RELATIONSHIP_8');
            $table->date('DESDE');
            $table->date('HASTA');
            
            $table->primary(['YEAR', 'IDEMPRESA']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('periodocontable');
    }
}
