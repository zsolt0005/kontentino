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
            $table->integer('rotation_period');
            $table->integer('orbital_period');
            $table->integer('diameter');
            $table->string('climate');
            $table->string('gravity');
            $table->string('terrain');
            $table->integer('surface_water');
            $table->integer('population');
            $table->date('created_at');
            $table->date('edited_at');
        });

        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('height');
            $table->integer('mass');
            $table->string('hair_color');
            $table->string('skin_color');
            $table->string('eye_color');
            $table->string('birth_year');
            $table->enum('gender', ['m', 'f']);
            $table->unsignedBigInteger('homeworld_id');
            $table->date('created_at');
            $table->date('edited_at');

            $table->foreign('homeworld_id')
                ->references('id')
                ->on('planets')
                ->onDelete('restrict');
        });

        Schema::create('planets_to_people', function (Blueprint $table) {
            $table->unsignedBigInteger('planet_id');
            $table->unsignedBigInteger('person_id');

            $table->foreign('planet_id')
                ->references('id')
                ->on('planets')
                ->onDelete('restrict');

            $table->foreign('person_id')
                ->references('id')
                ->on('people')
                ->onDelete('restrict');

            $table->primary(['planet_id', 'person_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planets_to_people');
        Schema::dropIfExists('people');
        Schema::dropIfExists('planets');
    }
};
