<?php

declare(strict_types=1);

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('transaction_key')->unique();
            $table->unsignedBigInteger('payer_id');
            $table->unsignedBigInteger('payee_id');
            $table->decimal('value', 10, 2);
            $table->enum('status', ['PENDING', 'COMPLETED', 'FAILED', 'REVERTED']);
            $table->timestamps();
            
            $table->foreign('payer_id')->references('id')->on('customers');
            $table->foreign('payee_id')->references('id')->on('customers');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('reverted_transaction_id')->nullable();
            $table->foreign('reverted_transaction_id')->references('id')->on('transactions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
}
