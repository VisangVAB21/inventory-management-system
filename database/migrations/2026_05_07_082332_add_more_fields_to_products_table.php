<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('description')->nullable()->after('name');
            $table->decimal('buy_price', 15, 2)->default(0)->after('description');
            $table->integer('initial_stock')->default(0)->after('stock');
            $table->string('image')->nullable()->after('ukuran');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['description', 'buy_price', 'initial_stock', 'image']);
        });
    }
};