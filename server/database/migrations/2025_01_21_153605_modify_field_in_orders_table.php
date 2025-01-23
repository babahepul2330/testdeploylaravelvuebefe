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
        Schema::table('orders', function (Blueprint $table) {
            $table->enum("status", [
                "pending",
                "success",
                "cancel"
            ])
                ->nullable()
                ->default(null)
                ->change();
            $table->after("address", function ($table) {
                return $table->double("price");
            });
            $table->string('order_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum("status", [
                "pending",
                "success",
                "cancel"
            ])
                ->default("pending")
                ->change();
            $table->dropColumn('price');
            $table->integer('order_id')->change();
        });
    }
};
