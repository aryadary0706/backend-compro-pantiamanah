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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name');
            $table->string('account_number');
            $table->string('account_holder');
            $table->timestamps();
        });

        Schema::create('needs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('photo')->nullable();
            $table->decimal('target_amount', 15, 2);
            $table->decimal('collected_amount', 15, 2)->default(0);
            $table->foreignId('bank_account_id')
            ->constrained('bank_accounts')
            ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
        Schema::dropIfExists('donasis');
    }
};
