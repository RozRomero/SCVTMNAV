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
        Schema::create('datos_empleados', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->nullable()->constrained('users');
            $table->date('fecha_ingreso')->nullable();
            $table->integer('antiguedad')->nullable();
            $table->integer('dias_vacaciones')->nullable();
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
        Schema::dropIfExists('datos_empleados');
    }
};
