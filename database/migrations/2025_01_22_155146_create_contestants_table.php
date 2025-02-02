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
        Schema::create('contestants', function (Blueprint $table) {
            $table->id();
            $table->string('names');
            $table->text('description')->nullable(); // Campo opcional para la descripción
            $table->string('status')->default('Activo')->nullable();
            $table->foreignId('contest_id')->nullable()->unsigned()->constrained('contests');
            $table->foreignId('category_id')->nullable()->unsigned()->constrained('categories');
            $table->timestamps(); // Incluye `created_at` y `updated_at`
            $table->softDeletes(); // Añade soporte para soft deletes

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contestants');
    }
};
