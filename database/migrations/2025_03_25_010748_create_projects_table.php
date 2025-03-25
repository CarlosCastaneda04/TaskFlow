<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');                      // Nombre del proyecto
            $table->text('description')->nullable();     // Descripción (opcional)
            $table->date('start_date')->nullable();      // Fecha de inicio
            $table->date('end_date')->nullable();        // Fecha de finalización
            $table->timestamps();                        // created_at y updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
}
