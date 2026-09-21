<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('health_records', function (Blueprint $table) {
            $table->id(); $table->foreignId('pet_id')->constrained()->cascadeOnDelete();
            $table->string('record_type'); $table->string('title'); $table->text('description')->nullable();
            $table->dateTime('recorded_at'); $table->string('provider_name')->nullable();
            $table->text('medication')->nullable(); $table->dateTime('follow_up_at')->nullable(); $table->timestamps();
            $table->index(['pet_id','record_type','recorded_at']);
        });
    }
    public function down(): void { Schema::dropIfExists('health_records'); }
};
