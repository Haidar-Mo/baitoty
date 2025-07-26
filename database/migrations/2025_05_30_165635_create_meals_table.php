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
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kitchen_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('ingredients');
            $table->unsignedInteger('type'); //- 1: for moona , 2: for normal
            $table->decimal('price');
            $table->decimal('new_price')->nullable();
            $table->string('meal_form');
            $table->boolean('is_available')->default(true);
            $table->timestamps();

            $table->index('kitchen_id');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meals');
    }
};
