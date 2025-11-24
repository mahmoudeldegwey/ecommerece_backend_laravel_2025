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
        DB::statement("
            CREATE VIEW product_statistics_view AS
            SELECT COUNT(*) AS total_products, COUNT(CASE WHEN quantity > 0 THEN 1 END) AS in_stock, COUNT(CASE WHEN quantity = 0 THEN 1 END) AS out_of_stock FROM products; 
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS product_statistics_view");
    }
};
