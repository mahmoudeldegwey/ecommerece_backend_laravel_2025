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
        Schema::table('products', function (Blueprint $table) {
            $table->string('name_ar',250)->after('name');
            $table->string('sku',100)->after('name_ar')->nullable()->unique();
            $table->text('description')->after('sku');
            $table->text('description_ar')->after('description');
            $table->text('seo_title')->after('description_ar')->nullable();
            $table->text('seo_description')->after('seo_title')->nullable();
            $table->decimal('sale_price')->after('price')->nullable();
            $table->text('main_image')->after('sale_price');
            $table->integer('quantity')->after('main_image')->default('0')->change();
            $table->integer('views')->after('quantity')->default('0');
            $table->tinyInteger('has_free_shipping')->after('views')->default('0');
            $table->tinyInteger('has_multi_color')->after('has_free_shipping')->default('0');
            $table->tinyInteger('has_multi_size')->after('has_multi_color')->default('0');
            $table->foreignId('brand_id')->constrained('brands')->nullable()->after('has_multi_size');
        });

        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('category_id')->constrained('categories');
        });

        Schema::create('product_colors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('color_id')->constrained('colors');
            $table->text('image')->nullable();
            $table->decimal('price')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();
            $table->softDeletes();
        });

        Schema::create('product_size', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('size_id')->constrained('sizes');
            $table->text('image')->nullable();
            $table->decimal('price')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
        Schema::dropIfExists('product_colors');
        Schema::dropIfExists('product_size');
    }
};
