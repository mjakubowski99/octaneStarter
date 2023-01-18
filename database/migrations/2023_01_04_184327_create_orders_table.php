<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('buyer_id');
            $table->uuid('product_id');
            $table->string('payment_provider_order_id')->unique();
            $table->unsignedTinyInteger('payment_provider_id');
            $table->unsignedTinyInteger('order_status_id');
            $table->integer('amount');
            $table->string('currency');
            $table->timestamps();

            $table->foreign('buyer_id')->references('id')->on('users');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('order_status_id')->references('id')->on('order_statuses');
            $table->foreign('payment_provider_id')->references('id')->on('payment_providers');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
