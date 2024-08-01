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
            $table->id();

                     
            $table->string('invoice_id')->nullable();
            $table->double('sub_total')->nullable();
            $table->text('coupon')->nullable();
            $table->double('amount')->nullable();
            $table->integer('product_qty')->nullable();
         
            $table->string('payment_method')->nullable();
            $table->text('shipping_method')->nullable();
            $table->integer('payment_status')->nullable();
            $table->text('order_address')->nullable();
            $table->integer('order_status')->nullable();
            $table->string('status')->nullable(); 
            $table->text('transaction_id')->nullable();
            $table->string('currency')->nullable();

            
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
