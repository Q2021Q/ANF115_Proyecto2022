<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccesousuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accesousuario', function (Blueprint $table) {
            $table->integer('IDOPCION')->nullable()->index('FK_RELATIONSHIP_16');
            $table->integer('IDUSUARIO')->nullable()->index('FK_RELATIONSHIP_17');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accesousuario');
    }
}
