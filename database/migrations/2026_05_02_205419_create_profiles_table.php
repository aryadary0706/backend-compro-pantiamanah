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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('ketua_yayasan');
            $table->int('tahun_periode');
            $table->string('profil_text');
            $table->string('email');
            $table->string('phone_number');
            $table->string('whatsapp_number');
            $table->string('qris_code')->nullable();
            $table->string('whatsapp_link')->nullable();
            $table->string('instagram')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
