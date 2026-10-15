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
            $table->string('hardcover_price')->nullable()->after('paperback_price');
            $table->string('lulu_hardcover_pod_package_id', 100)->nullable()->after('lulu_pod_package_id');
            $table->text('lulu_hardcover_cover_url')->nullable()->after('lulu_cover_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'hardcover_price',
                'lulu_hardcover_pod_package_id',
                'lulu_hardcover_cover_url',
            ]);
        });
    }
};

