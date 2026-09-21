<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('adoption_interests', function (Blueprint $table) {
            $table->id(); $table->foreignId('adoption_listing_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); $table->text('message');
            $table->string('status')->default('pending'); $table->timestamps();
            $table->unique(['adoption_listing_id','user_id']);
        });
    }
    public function down(): void { Schema::dropIfExists('adoption_interests'); }
};
