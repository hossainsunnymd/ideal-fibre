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
        Schema::create('invoice_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('product_id');
            $table->foreign('invoice_id')->references('id')->on('invoices')
            ->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('product_id')->references('id')->on('products')
            ->restrictOnDelete()->cascadeOnUpdate();
            $table->integer('qty');
            $table->decimal('rate',15,2);
            $table->decimal('order_price',15,2);
            $table->integer('complete_work_order');
            $table->integer('incomplete_work_order');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_products');
    }
};
