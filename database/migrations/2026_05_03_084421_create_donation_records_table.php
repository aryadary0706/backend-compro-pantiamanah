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
        Schema::create('donation_records', function (Blueprint $table) {
            $table->id();
            $table->string('donor_name');
            $table->string('phone_number');
            $table->string('tujuan');
            $table->foreignId('donasi_id')->nullable()->constrained('needs')->nullOnDelete();
            $table->foreignId('bank_account_id')->constrained('bank_accounts')->restrictOnDelete();
            $table->decimal('amount', 15, 2);
            $table->string('payment_proof');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_records');
    }
};
