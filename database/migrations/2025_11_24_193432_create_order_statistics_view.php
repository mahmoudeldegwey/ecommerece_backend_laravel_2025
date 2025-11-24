<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE VIEW order_statistics_view AS
            SELECT 
                COUNT(*) AS total_orders,
                COUNT(CASE WHEN status = 'delivered' THEN 1 END) AS order_delivered,
                COUNT(CASE WHEN status = 'shipped' THEN 1 END) AS order_shipped,
                COUNT(CASE WHEN status = 'pending' THEN 1 END) AS order_pending
            FROM orders
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS order_statistics_view");
    }
};
