<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\{Country,City};

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('product_count');
            $table->string('customer_name',250);
            $table->string('customer_email',250);
            $table->string('customer_phone',50);
            $table->string('customer_address');
            $table->foreignIdFor(Country::class);
            $table->foreignIdFor(City::class);
            $table->string('payment_method',50);
            $table->boolean('use_different_billing_address')->default(false);
            $table->jsonb('billing_address')->nullable();
            $table->integer('products_count');
            $table->integer('products_quantity');
            $table->decimal('shipping_cost');
            $table->decimal('final_cost');
            $table->boolean('coupon_applied')->default(false);
            $table->decimal('discount_price')->nullable();
            $table->decimal('discount_amount')->nullable();
            $table->string('coupon_code',50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
