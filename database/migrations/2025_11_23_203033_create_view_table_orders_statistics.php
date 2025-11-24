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
        Schema::create('view_table_orders_statistics', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_table_orders_statistics');
    }
};


// SELECT COUNT(*) as total_orders, (SELECT COUNT(*) FROM orders WHERE status = 'delivered') as orders_delivered, (SELECT COUNT(*) FROM orders WHERE status = 'pending') as orders_pending, (SELECT COUNT(*) FROM orders WHERE status = 'shipped') as orders_shipped FROM orders; 

// id 	select_type 	table 	partitions 	type 	possible_keys 	key 	key_len 	ref 	rows 	filtered 	Extra 	
// 1 	PRIMARY 	orders 	NULL 	index 	NULL 	PRIMARY 	8 	NULL 	31 	100.00 	Using index
// 4 	SUBQUERY 	orders 	NULL 	ALL 	NULL 	NULL 	NULL 	NULL 	31 	12.50 	Using where
// 3 	SUBQUERY 	orders 	NULL 	ALL 	NULL 	NULL 	NULL 	NULL 	31 	12.50 	Using where
// 2 	SUBQUERY 	orders 	NULL 	ALL 	NULL 	NULL 	NULL 	NULL 	31 	12.50 	Using where

// EXPLAIN SELECT 
//     COUNT(*) AS total_orders,
//     COUNT(CASE WHEN status = 'delivered' THEN 1 END) AS order_delivered,
//     COUNT(CASE WHEN status = 'shipped' THEN 1 END) AS order_shipped,
//     COUNT(CASE WHEN status = 'pending' THEN 1 END) AS order_pending
// FROM orders;

// id 	select_type 	table 	partitions 	type 	possible_keys 	key 	key_len 	ref 	rows 	filtered 	Extra 	
// 1 	SIMPLE 	orders 	NULL 	ALL 	NULL 	NULL 	NULL 	NULL 	31 	100.00 	NULL 