<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Table des comptes bancaires des clients
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cnic');
            $table->string('account_no')->unique();
            $table->string('account_type'); // current ou saving
            $table->string('city');
            $table->string('address');
            $table->string('email')->unique();
            $table->string('password');
            $table->decimal('balance', 12, 2)->default(0);
            $table->string('source'); // source de revenus
            $table->string('contact');
            $table->string('image')->nullable(); // photo du client
            $table->foreignId('branch_id')->constrained('branches');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
