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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('head_family_id')->constrained('wargas')->onDelete('cascade');
            $table->enum('transaction_type', ['pemasukan', 'pengeluaran']);
            $table->decimal('amount', 15, 2);
            $table->string('category');
            $table->text('description')->nullable();
            $table->date('transaction_date');
            $table->decimal('anomaly_score', 10, 6)->nullable();
            $table->boolean('is_anomaly')
                ->default(false);
            $table->enum('audit_status', [
                'normal',
                'review',
                'verified'
            ])->default('normal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};