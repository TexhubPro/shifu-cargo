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
        Schema::create('held_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('client')->nullable();
            $table->string('order_no')->nullable();
            $table->string('deliver_boy')->nullable();
            $table->foreignId('queue_id')->nullable()->constrained('queues')->nullOnDelete();
            $table->decimal('delivery_price', 12, 2)->default(0);
            $table->decimal('weight', 12, 3)->default(0);
            $table->decimal('volume', 12, 3)->default(0);
            $table->string('payment_type')->nullable();
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('discount_total', 12, 2)->default(0);
            $table->string('discountt')->default('Фиксированная');
            $table->decimal('total_final', 12, 2)->default(0);
            $table->json('tracks')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('held_orders');
    }
};
