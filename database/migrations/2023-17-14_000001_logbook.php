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
        Schema::create('logbook', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('person_id')->comment('Id of the person who created the log');
            $table->unsignedBigInteger('planet_id')->comment('Id of the planet where the log was created at');

            $table->point('location')->comment('GPS Location where the log was created at');
            $table->unsignedTinyInteger('severity')->comment('Higher number = greater severity');
            $table->text('note')->comment('Encrypted note');

            $table->date('created_at')->comment('Creation date time of the log');

            $table->foreign('person_id')
                ->references('id')
                ->on('people')
                ->onDelete('restrict');

            $table->foreign('planet_id')
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
        Schema::dropIfExists('logbook');
    }
};
