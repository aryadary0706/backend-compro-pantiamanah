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
        Schema::create('profile', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('email_information')->nullable();
            $table->string('phone_number');
            $table->string('Whatsapp_number');
            $table->string('contact_information')->nullable();
            $table->text('Operational_information')->nullable();
            $table->text('qris_code')->nullable();
            $table->string('whatsapp_link')->nullable();
            $table->timestamps();
        });

        Schema::create('donasi', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('bank_account_id');
            $table->string('description');
            $table->string('photo')->nullable();
            $table->decimal('target_amount', 15, 2);
            $table->decimal('collected_amount', 15, 2)->default(0);
            $table->timestamps();
        });


        Schema::create('anak_asuh', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('age');
            $table->string('education');
            $table->string('badge')->nullable();
            $table->text('description')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });

        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('message');
            $table->integer('rating')->default(0);
            $table->timestamps();
        });

        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name');
            $table->string('account_number');
            $table->string('account_holder');
            $table->string('logo')->nullable();
            $table->timestamps();
        });

        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            $table->integer('child_count');
            $table->string('google_maps_url')->nullable();
            $table->timestamps();
        });

        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('icon')->nullable();
            $table->string('color_theme')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile');
        Schema::dropIfExists('donasi');
        Schema::dropIfExists('anak_asuh');
        Schema::dropIfExists('feedback');
        Schema::dropIfExists('bank_accounts');
        Schema::dropIfExists('locations');
        Schema::dropIfExists('programs');
    }
};
