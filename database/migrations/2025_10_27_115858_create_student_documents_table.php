<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('enrollment_id')->nullable();
            $table->string('enrollment_type')->nullable(); // 'new' or 'old'
            $table->string('document_type'); // 'report_card', 'good_moral', 'birth_certificate', 'id_picture', 'payment_receipt'
            $table->string('original_filename');
            $table->string('mime_type');
            $table->bigInteger('file_size'); // in bytes
            $table->longText('file_data'); // Store actual file content as base64 encoded text
            $table->timestamps();
            
            $table->index(['enrollment_id', 'enrollment_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_documents');
    }
};
