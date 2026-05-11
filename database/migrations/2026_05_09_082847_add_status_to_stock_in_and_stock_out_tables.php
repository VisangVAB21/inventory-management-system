<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('stock_ins', function (Blueprint $table) {
            $table->enum('status', ['pending', 'checked'])->default('pending')->after('note');
        });

        Schema::table('stock_outs', function (Blueprint $table) {
            $table->enum('status', ['pending', 'prepared'])->default('pending')->after('date');
        });
    }

    public function down()
    {
        Schema::table('stock_ins', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('stock_outs', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};