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
        Schema::table('new_student_enrollees', function (Blueprint $table) {
            // Add missing columns
            $table->string('strand')->nullable()->after('preferred_strand');
            $table->string('surname')->nullable()->after('strand');
            $table->string('given_name')->nullable()->after('surname');
            $table->string('contact_no')->nullable()->after('given_name');
            $table->string('living_with')->nullable()->after('contact_no');
            $table->string('birthplace')->nullable()->after('living_with');
            $table->string('religion')->nullable()->after('birthplace');
            $table->string('nationality')->nullable()->after('religion');
            $table->string('former_school')->nullable()->after('nationality');
            $table->string('previous_grade')->nullable()->after('former_school');
            $table->string('last_school_year')->nullable()->after('previous_grade');
            $table->string('school_type')->nullable()->after('last_school_year');
            $table->string('reason_transfer')->nullable()->after('school_type');
            $table->boolean('working_student')->default(false)->after('reason_transfer');
            $table->boolean('intend_working_student')->default(false)->after('working_student');
            $table->integer('siblings')->nullable()->after('intend_working_student');
            $table->boolean('club_member')->default(false)->after('siblings');
            $table->string('club_name')->nullable()->after('club_member');
            $table->string('father_occupation')->nullable()->after('club_name');
            $table->string('father_contact_no')->nullable()->after('father_occupation');
            $table->string('father_email')->nullable()->after('father_contact_no');
            $table->string('mother_occupation')->nullable()->after('father_email');
            $table->string('mother_contact_no')->nullable()->after('mother_occupation');
            $table->string('mother_email')->nullable()->after('mother_contact_no');
            $table->string('guardian_occupation')->nullable()->after('mother_email');
            $table->string('guardian_contact_no')->nullable()->after('guardian_occupation');
            $table->json('medical_history')->nullable()->after('guardian_contact_no');
            $table->string('allergy_specify')->nullable()->after('medical_history');
            $table->string('others_specify')->nullable()->after('allergy_specify');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('new_student_enrollees', function (Blueprint $table) {
            $table->dropColumn([
                'strand', 'surname', 'given_name', 'contact_no', 'living_with', 'birthplace',
                'religion', 'nationality', 'former_school', 'previous_grade', 'last_school_year',
                'school_type', 'reason_transfer', 'working_student', 'intend_working_student',
                'siblings', 'club_member', 'club_name', 'father_occupation', 'father_contact_no',
                'father_email', 'mother_occupation', 'mother_contact_no', 'mother_email',
                'guardian_occupation', 'guardian_contact_no', 'medical_history', 'allergy_specify',
                'others_specify'
            ]);
        });
    }
};