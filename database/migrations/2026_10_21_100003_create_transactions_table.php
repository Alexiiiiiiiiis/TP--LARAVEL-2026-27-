<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Table des opérations (dépôt, retrait, virement envoyé / reçu)
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            // si le compte est supprimé, ses opérations le sont aussi
            $table->foreignId('account_id')->constrained('accounts')->cascadeOnDelete();
            $table->string('action'); // deposit, withdraw, transfer, received
            $table->decimal('credit', 12, 2)->nullable();
            $table->decimal('debit', 12, 2)->nullable();
            $table->string('other')->nullable(); // n° du compte de l'autre partie (virements)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
