<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatiogeneralTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratiogeneral', function (Blueprint $table) {
            $table->integer('IDGENERALRATIO')->primary();
            $table->integer('IDRATIO')->index('FK_RELATIONSHIP_15');
            $table->decimal('VALORRATIOGENERAL', 2, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratiogeneral');
    }
}
