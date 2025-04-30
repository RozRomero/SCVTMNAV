<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('departamento_empleado', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('departamento_id')->constrained('catalogo_departamentos')->onDelete('cascade');
            $table->timestamps();
        });

        // Only drop the column if it exists (for existing installations)
        if (Schema::hasColumn('users', 'departmento_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['departmento_id']);
                $table->dropColumn('departmento_id');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('departamento_empleado');
        
    }
};