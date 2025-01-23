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
        Schema::create('contestant_wins', function (Blueprint $table) {
            $table->id(); // Crea el campo `id` como clave primaria
            $table->foreignId('user_id')->nullable()->unsigned()->constrained('users');
            $table->foreignId('contest_id')->nullable()->unsigned()->constrained('contests');
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
        Schema::dropIfExists('contestant_wins');
    }
};
