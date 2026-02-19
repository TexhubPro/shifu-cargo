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
        if (!Schema::hasColumn('orders', 'warehouse_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->foreignId('warehouse_id')
                    ->nullable()
                    ->after('user_id')
                    ->constrained('warehouses')
                    ->nullOnDelete();
            });
        }

        if (!Schema::hasColumn('orders', 'payment_type')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('payment_type')
                    ->default('Наличными')
                    ->after('status');
            });
        }

        if (!Schema::hasColumn('expences', 'warehouse_id')) {
            Schema::table('expences', function (Blueprint $table) {
                $table->foreignId('warehouse_id')
                    ->nullable()
                    ->after('user_id')
                    ->constrained('warehouses')
                    ->nullOnDelete();
            });
        }

        if (!Schema::hasColumn('expences', 'added_by_id')) {
            Schema::table('expences', function (Blueprint $table) {
                $table->foreignId('added_by_id')
                    ->nullable()
                    ->after('warehouse_id')
                    ->constrained('users')
                    ->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('orders', 'warehouse_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropConstrainedForeignId('warehouse_id');
            });
        }

        if (Schema::hasColumn('orders', 'payment_type')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('payment_type');
            });
        }

        if (Schema::hasColumn('expences', 'added_by_id')) {
            Schema::table('expences', function (Blueprint $table) {
                $table->dropConstrainedForeignId('added_by_id');
            });
        }

        if (Schema::hasColumn('expences', 'warehouse_id')) {
            Schema::table('expences', function (Blueprint $table) {
                $table->dropConstrainedForeignId('warehouse_id');
            });
        }
    }
};
