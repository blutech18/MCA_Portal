<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StrandAssessmentResult;
use Illuminate\Support\Facades\Validator;

class StrandAssessmentController extends Controller
{
    public function showResult(Request $request)
    {
        // Get the strand from query string (set in JS redirect)
        $strand = $request->query('strand', 'GAS'); 
        $email = $request->query('email');
        $saved = $request->query('saved', false);
        
        // Set assessment email in session for enrollment flow if email is provided
        if ($email) {
            session(['assessment_email' => $email]);
        }
        
        // Descriptions for each strand
        $descriptions = [
            'STEM'  => 'Science, Technology, Engineering, and Mathematics – ideal for hands-on problem solvers.',
            'ABM'   => 'Accountancy, Business, and Management – great for future entrepreneurs and finance experts.',
            'GAS'   => 'General Academic Strand – broad curriculum for those exploring multiple fields.',
            'HUMSS' => 'Humanities and Social Sciences – perfect for communicators and critical thinkers.',
            'ICT'   => 'Information and Communications Technology – suited for those passionate about tech systems.',
            'HE'    => 'Home Economics – for individuals interested in hospitality, nutrition, and lifestyle services.',
        ];

        // Get assessment results if email is provided
        $assessmentResult = null;
        if ($email) {
            $assessmentResult = StrandAssessmentResult::latestForEmail($email)->first();
        }

        // Pass data to the view
        return view('assessment_result', compact('strand', 'descriptions', 'email', 'saved', 'assessmentResult'));
    }

    /**
     * Store assessment results via AJAX
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'recommended_strand' => 'required|string|in:STEM,ABM,GAS,HUMSS,ICT,HE',
            'scores' => 'required|array',
            'total_questions' => 'required|integer|min:1',
            'completed_at' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Get current academic year
            $currentAcademicYear = \App\Models\AcademicYear::getOrCreateCurrentAcademicYear();
            
            // Check if email already has assessment for current academic year
            $existingAssessment = StrandAssessmentResult::where('email', $request->email)
                ->where('academic_year_id', $currentAcademicYear->id)
                ->first();

            if ($existingAssessment) {
                // Update existing assessment (unlimited retakes)
                $existingAssessment->update([
                    'recommended_strand' => $request->recommended_strand,
                    'scores' => $request->scores,
                    'total_questions' => $request->total_questions,
                    'completed_at' => $request->completed_at,
                    'is_used' => false // Reset usage flag for retakes
                ]);

                $assessmentResult = $existingAssessment;
            } else {
                // Create new assessment result
                $assessmentResult = StrandAssessmentResult::create([
                    'email' => $request->email,
                    'academic_year_id' => $currentAcademicYear->id,
                    'recommended_strand' => $request->recommended_strand,
                    'scores' => $request->scores,
                    'total_questions' => $request->total_questions,
                    'completed_at' => $request->completed_at
                ]);
            }

            return response()->json([
                'success' => true,
                'assessment_id' => $assessmentResult->id,
                'message' => 'Assessment results saved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving assessment results: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if email has existing assessment for current academic year
     */
    public function checkAssessment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email format'
            ], 422);
        }

        // Check for assessment in current academic year only
        $assessmentResult = StrandAssessmentResult::latestForEmail($request->email)->first();

        return response()->json([
            'success' => true,
            'has_assessment' => $assessmentResult !== null,
            'assessment' => $assessmentResult ? [
                'recommended_strand' => $assessmentResult->recommended_strand,
                'completed_at' => $assessmentResult->completed_at->format('M d, Y'),
                'scores' => $assessmentResult->getAllScorePercentages(),
                'academic_year' => $assessmentResult->academicYear?->year_name ?? 'Unknown'
            ] : null
        ]);
    }

    /**
     * Set assessment email in session for enrollment flow
     */
    public function setAssessmentEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email format'
            ], 422);
        }

        // Set email in session for enrollment flow
        session(['assessment_email' => $request->email]);

        return response()->json([
            'success' => true,
            'message' => 'Assessment email set in session'
        ]);
    }
}
