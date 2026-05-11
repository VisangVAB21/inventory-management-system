<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('stock_transactions', function (Blueprint $table) {
        $table->foreignId('user_id')->nullable()->constrained('users');
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        $table->foreignId('confirmed_by')->nullable()->constrained('users');
        $table->timestamp('confirmed_at')->nullable();
        $table->text('notes')->nullable();
        $table->text('description')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_transactions', function (Blueprint $table) {
            //
        });
    }
};
