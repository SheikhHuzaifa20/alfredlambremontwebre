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
            $table->string('text2')->nullable();
            $table->string('short_text')->nullable();
            $table->string('paperback_price')->nullable();
            $table->string('ebook_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'text2',
                'short_text',
                'paperback_price',
                'ebook_price',
            ]);
        });
    }
};
