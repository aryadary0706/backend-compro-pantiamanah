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
        Schema::create('anak_asuhs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('age');
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir');
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->enum('education', ['Tidak Sekolah', 'TK', 'SD', 'SMP', 'SMK', 'SMA', 'Kuliah']);
            $table->string('education_level');
            $table->enum('status', ['Dhuafa', 'Yatim', 'Piatu']);
            $table->text('description')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anak_asuhs');
    }
};
