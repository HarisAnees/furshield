<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id(); $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pet_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vet_id')->constrained()->cascadeOnDelete();
            $table->dateTime('starts_at'); $table->dateTime('ends_at')->nullable();
            $table->string('reason'); $table->text('symptoms')->nullable();
            $table->string('status')->default('scheduled'); $table->text('diagnosis')->nullable();
            $table->text('medication')->nullable(); $table->text('follow_up_notes')->nullable(); $table->timestamps();
            $table->index(['vet_id','starts_at']); $table->index(['user_id','starts_at']);
        });
    }
    public function down(): void { Schema::dropIfExists('appointments'); }
};
