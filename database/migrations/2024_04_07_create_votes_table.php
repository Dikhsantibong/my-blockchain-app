<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('candidate_id')->constrained()->onDelete('cascade');
            $table->string('transaction_hash')->nullable(); // For storing Ethereum transaction hash
            $table->timestamps();
            $table->unique(['user_id']); // Ensure one vote per user
        });
    }

    public function down()
    {
        Schema::dropIfExists('votes');
    }
}; 