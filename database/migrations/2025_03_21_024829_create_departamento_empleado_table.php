<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('departamento_empleado', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('departamento_id')->constrained('catalogo_departamentos')->onDelete('cascade');
            $table->timestamps();
        });

        // Eliminar la clave foránea existente en users
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['departmento_id']);
            $table->dropColumn('departmento_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restaurar la columna department_id en users
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('departmento_id')->nullable()->after('password')->constrained('catalogo_departamentos');
        });

        Schema::dropIfExists('departamento_empleado');
    }
};

