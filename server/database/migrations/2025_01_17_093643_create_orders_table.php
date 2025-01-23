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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
            $table->foreignUuid('product_id')
                ->references('id')
                ->on('products')
                ->cascadeOnDelete();
            $table->integer("order_id")->unique();
            $table->string("first_name");
            $table->string("last_name");
            $table->text("address");
            $table->double("total_price");
            $table->integer("quantity");
            $table->enum("status", [
                "pending",
                "success",
                "cancel"
            ])->default("pending");
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
