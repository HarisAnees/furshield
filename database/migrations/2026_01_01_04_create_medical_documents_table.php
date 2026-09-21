<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('medical_documents', function (Blueprint $table) {
            $table->id(); $table->foreignId('pet_id')->constrained()->cascadeOnDelete();
            $table->string('title'); $table->string('document_type'); $table->string('file_path');
            $table->string('mime_type')->nullable(); $table->unsignedBigInteger('file_size')->nullable(); $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('medical_documents'); }
};
