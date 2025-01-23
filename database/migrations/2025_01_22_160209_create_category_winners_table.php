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
        Schema::create('category_winners', function (Blueprint $table) {
            $table->id(); // Crea el campo `id` como clave primaria
            $table->string('status')->default('Activo')->nullable();
            $table->foreignId('contest_id')->nullable()->unsigned()->constrained('contests');
            $table->foreignId('category_id')->nullable()->unsigned()->constrained('categories');
            $table->foreignId('contestant_id')->nullable()->unsigned()->constrained('contestants');
            
            $table->timestamps(); // Crea los campos `created_at` y `updated_at`
            $table->softDeletes(); // Crea el campo `deleted_at` para soportar soft deletes


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_winners');
    }
};
