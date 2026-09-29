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
            $table->boolean('is_lulu_fulfillable')->default(false)->after('status');
            $table->string('lulu_pod_package_id', 100)->nullable()->after('is_lulu_fulfillable');
            $table->text('lulu_interior_url')->nullable()->after('lulu_pod_package_id');
            $table->text('lulu_cover_url')->nullable()->after('lulu_interior_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'is_lulu_fulfillable',
                'lulu_pod_package_id',
                'lulu_interior_url',
                'lulu_cover_url',
            ]);
        });
    }
};

