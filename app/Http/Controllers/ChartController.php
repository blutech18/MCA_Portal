<?php

namespace App\Http\Controllers;

use App\Models\Strand;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function index()
    {
        // Fetch strands with their section count (assuming 'section_count' exists in DB)
        $strands = Strand::all();

        // Extract labels (strand names) and data (number of sections)
        $labels = $strands->pluck('name');              // e.g., ["STEM", "ABM", "HUMSS"]
        $sections = $strands->pluck('no_of_sections');    // e.g., [3, 5, 2]

        return view('admin_dashboard', compact('labels', 'sections'));
    }
}
