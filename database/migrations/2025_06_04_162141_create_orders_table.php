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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('kitchen_id')->constrained('kitchens')->cascadeOnDelete();
            $table->foreignId('meal_id')->constrained('meals')->cascadeOnDelete();
            $table->integer('count', false, true);
            $table->decimal('total_price');
            $table->string('phone_number');
            $table->double('latitude')->default(0.0);
            $table->double('longitude')->default(0.0);
            $table->string('notes')->nullable()->default('لا يوجد');
            $table->string('qr_code')->unique()->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
