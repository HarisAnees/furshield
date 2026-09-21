<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('vet_availabilities', function(Blueprint $t){$t->id();$t->foreignId('vet_id')->constrained('vets')->cascadeOnDelete();$t->unsignedTinyInteger('day_of_week');$t->time('start_time');$t->time('end_time');$t->boolean('is_active')->default(true);$t->timestamps();$t->index(['vet_id','day_of_week']);}); } public function down(): void {Schema::dropIfExists('vet_availabilities');}};
