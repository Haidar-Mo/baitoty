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
        Schema::create('kitchens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            // $table->foreignId('city_id')->constrained('cities')->cascadeOnDelete();
            // $table->string('address');
            $table->double('latitude')->default(0.0);
            $table->double('longitude')->default(0.0);
            $table->string('phone_number');
            $table->string('second_phone_number')->nullable();
            $table->boolean('can_deliver')->default(0);
            $table->time('open_at')->default('08:00');
            $table->time('close_at')->default('22:00');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kitchens');
    }
};
