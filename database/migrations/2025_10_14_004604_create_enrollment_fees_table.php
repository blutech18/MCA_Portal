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
        Schema::create('enrollment_fees', function (Blueprint $table) {
            $table->id();
            $table->enum('fee_type', ['new_jhs', 'new_shs', 'old_jhs', 'old_shs']);
            $table->decimal('amount', 10, 2);
            $table->date('effective_date');
            $table->unsignedBigInteger('created_by');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('created_by')->references('user_id')->on('users')->onDelete('cascade');
            
            // Indexes for performance
            $table->index(['fee_type', 'is_active']);
            $table->index(['effective_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollment_fees');
    }
};
