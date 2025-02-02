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
        Schema::create('bets', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('Activo')->nullable();
            $table->foreignId('user_id')->nullable()->unsigned()->constrained('users');
            $table->foreignId('contestant_id')->nullable()->unsigned()->constrained('contestants');
            $table->foreignId('category_id')->nullable()->unsigned()->constrained('categories');
            $table->foreignId('contest_bet_id')->nullable()->unsigned()->constrained('contest_bets');
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
        Schema::dropIfExists('bets');
    }
};
