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
        Schema::create('rel_users_vacaciones', function (Blueprint $table) {
            $table->id('id_rel_user_vacasiones');
            $table->foreignId('user_id')->nullable()->constrained('users')->references('id');
            $table->bigInteger('dias_vacaciones');//se iran restando
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
        Schema::dropIfExists('rel_users_vacaciones');
    }
};
