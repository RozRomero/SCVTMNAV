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
        Schema::table('datos_empleados', function (Blueprint $table) {
            $table->integer("dias_utilizados")->nullable()->after("dias_vacaciones");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('datos_empleados', function (Blueprint $table) {
            //
        });
    }
};
