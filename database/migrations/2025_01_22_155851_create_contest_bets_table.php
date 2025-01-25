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
        Schema::create('contest_bets', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('Activo')->nullable();
            $table->foreignId('user_id')->nullable()->unsigned()->constrained('users');
            $table->foreignId('contest_id')->nullable()->unsigned()->constrained('contests');

            $table->timestamps();
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
        Schema::dropIfExists('contest_bets');
    }
};
