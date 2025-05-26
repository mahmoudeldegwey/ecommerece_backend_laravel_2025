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
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('model',100)->nullable()->after('name');
            $table->string('value',100)->nullable()->after('model');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       
    }
};
