<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('planets', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('rotation_period')->nullable();
            $table->integer('orbital_period')->nullable();
            $table->integer('diameter')->nullable();
            $table->string('climate')->nullable();
            $table->string('gravity')->nullable();
            $table->string('terrain')->nullable();
            $table->integer('surface_water')->nullable();
            $table->unsignedBigInteger('population')->nullable();
            $table->date('created_at');
            $table->date('edited_at');
        });

        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('height')->nullable();
            $table->integer('mass')->nullable();
            $table->string('hair_color');
            $table->string('skin_color');
            $table->string('eye_color');
            $table->string('birth_year')->nullable();
            $table->enum('gender', ['male', 'female', 'hermaphrodite', 'unknown', 'n/a']);
            $table->unsignedBigInteger('homeworld_id');
            $table->date('created_at');
            $table->date('edited_at');

            $table->foreign('homeworld_id')
                ->references('id')
                ->on('planets')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
        Schema::dropIfExists('planets');
    }
};
