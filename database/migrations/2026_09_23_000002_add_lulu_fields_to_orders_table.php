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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('lulu_job_id', 100)->nullable()->after('order_status');
            $table->string('lulu_status', 50)->nullable()->after('lulu_job_id');
            $table->string('lulu_tracking_number', 100)->nullable()->after('lulu_status');
            $table->text('lulu_tracking_url')->nullable()->after('lulu_tracking_number');
            $table->decimal('lulu_cost', 10, 2)->nullable()->after('lulu_tracking_url');
            $table->text('lulu_error_message')->nullable()->after('lulu_cost');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'lulu_job_id',
                'lulu_status',
                'lulu_tracking_number',
                'lulu_tracking_url',
                'lulu_cost',
                'lulu_error_message',
            ]);
        });
    }
};

