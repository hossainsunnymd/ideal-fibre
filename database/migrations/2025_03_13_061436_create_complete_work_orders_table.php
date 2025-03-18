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
        Schema::create('complete_work_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_product_id');
            $table->unsignedBigInteger('product_id');
            $table->foreign('invoice_product_id')->references('id')->on('invoice_products')
            ->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('product_id')->references('id')->on('products')
            ->restrictOnDelete()->cascadeOnUpdate();
            $table->integer('work_order');
            $table->integer('delivered_work_order');
            $table->integer('pending_work_order');
            $table->string('delivered_by');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complete_work_orders');
    }
};
