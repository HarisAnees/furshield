<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('vets', function (Blueprint $table) {
            $table->id(); $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('specialization'); $table->unsignedSmallInteger('experience_years')->default(0);
            $table->text('bio')->nullable(); $table->string('clinic_name')->nullable(); $table->text('address')->nullable();
            $table->string('city')->nullable(); $table->decimal('latitude',10,7)->nullable(); $table->decimal('longitude',10,7)->nullable();
            $table->boolean('is_available')->default(true); $table->timestamps(); $table->index(['city','specialization']);
        });
    }
    public function down(): void { Schema::dropIfExists('vets'); }
};
