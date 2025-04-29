<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StrandAssessmentController extends Controller
{
    public function showResult(Request $request)
{
    // Get the strand from query string (set in JS redirect)
    $strand = $request->query('strand', 'GAS'); 
    // Descriptions for each strand
    $descriptions = [
        'STEM'  => 'Science, Technology, Engineering, and Mathematics – ideal for hands-on problem solvers.',
        'ABM'   => 'Accountancy, Business, and Management – great for future entrepreneurs and finance experts.',
        'GAS'   => 'General Academic Strand – broad curriculum for those exploring multiple fields.',
        'HUMSS' => 'Humanities and Social Sciences – perfect for communicators and critical thinkers.',
        'ICT'   => 'Information and Communications Technology – suited for those passionate about tech systems.',
        'HE'    => 'Home Economics – for individuals interested in hospitality, nutrition, and lifestyle services.',
    ];
    // Pass both to the view
    return view('assessment_result', compact('strand', 'descriptions'));
}

}
