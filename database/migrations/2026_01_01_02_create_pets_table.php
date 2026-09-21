<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('pets', function (Blueprint $table) {
            $table->id(); $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name'); $table->string('species'); $table->string('breed')->nullable();
            $table->date('date_of_birth')->nullable(); $table->string('sex')->default('unknown');
            $table->decimal('weight_kg',8,2)->nullable(); $table->string('microchip_number')->nullable()->index();
            $table->text('notes')->nullable(); $table->string('image_path')->nullable(); $table->timestamps();
            $table->index(['user_id','species']);
        });
    }
    public function down(): void { Schema::dropIfExists('pets'); }
};
