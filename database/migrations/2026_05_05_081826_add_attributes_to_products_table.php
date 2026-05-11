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
    Schema::table('products', function (Blueprint $table) {
        $table->string('kategori')->nullable();
        $table->string('merk')->nullable();
        $table->string('warna')->nullable();
        $table->string('ukuran')->nullable();
        $table->text('description')->nullable();
        $table->decimal('buy_price', 15, 2)->default(0);
        $table->integer('initial_stock')->default(0);
        $table->string('image')->nullable();
    });
}

public function down()
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn(['kategori', 'merk', 'warna', 'ukuran']);
    });
}
};
