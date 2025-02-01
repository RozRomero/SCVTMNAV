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
        Schema::create('solicitud_vacaciones', function (Blueprint $table) {
            $table->id('id_solicitud');
            // DATOS BASICOS
            $table->foreignId('user_id')->constrained('users')->references('id'); //USUARIO QUE SOLICITA
            $table->bigInteger('dias_solicitados'); //cantidad de dias 
            $table->date('fecha_inicio_vacaciones');//fecha en que inician las vacaciones
            $table->text("nota_de_solicitud");// informacion de a quien contactar/ quien lo cubre en esos dias.
            $table->foreignId('user_jefe_id')->constrained('users')->references('id'); //USUARIO JEFE QUE AUTORIZARA
            // CORREO
            $table->tinyInteger('flag_envio_correo')->nullable();
            $table->integer('contador_envio')->nullable();

            // APROBACION
            $table->tinyInteger('flag_aprobada')->nullable()->default('0')->comment("1: Aprobada 0: No aprobada");//flag si las vacaciones fueron aprobadas 1 aprobadas 0 no han sido aprobadas
            $table->date('fecha_aprobada')->nullable();//fecha en que fueron aprobadas

            $table->timestamps();
            $table->softDeletesTz();
            $table->foreignId('user_delete_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitud_vacaciones');
    }
};
