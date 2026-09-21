<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('adoption_listings', function (Blueprint $table) {
            $table->id(); $table->foreignId('shelter_id')->constrained()->cascadeOnDelete();
            $table->string('pet_name'); $table->string('species'); $table->string('breed')->nullable();
            $table->string('age_text')->nullable(); $table->string('sex')->nullable(); $table->text('health_summary')->nullable();
            $table->text('care_summary')->nullable(); $table->string('status')->default('available'); $table->string('image_path')->nullable(); $table->timestamps();
            $table->index(['status','species']);
        });
    }
    public function down(): void { Schema::dropIfExists('adoption_listings'); }
};
