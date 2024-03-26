<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('reverted_transaction_id')->nullable()->after('status');
            $table->foreign('reverted_transaction_id')->references('id')->on('transactions');
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['reverted_transaction_id']);
            $table->dropColumn('reverted_transaction_id');
        });
    }
};