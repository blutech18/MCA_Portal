<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    /**
     * Display academic years management page
     */
    public function index()
    {
        // Ensure we have academic years
        if (AcademicYear::count() === 0) {
            AcademicYear::createDefaultYears();
        }
        
        $academicYears = AcademicYear::orderBy('start_date', 'desc')->get();
        $currentAcademicYear = AcademicYear::getCurrentAcademicYear();
        
        return view('admin_academic_years', compact('academicYears', 'currentAcademicYear'));
    }
    
    /**
     * Store a new academic year
     */
    public function store(Request $request)
    {
        $request->validate([
            'year_name' => 'required|string|unique:academic_years,year_name',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_current' => 'boolean'
        ]);
        
        // If setting as current, remove current flag from others
        if ($request->is_current) {
            AcademicYear::where('is_current', true)->update(['is_current' => false]);
        }
        
        AcademicYear::create($request->all());
        
        return redirect()->route('admin.academic-years')
            ->with('success', 'Academic year created successfully.');
    }
    
    /**
     * Set an academic year as current
     */
    public function setCurrent($id)
    {
        $year = AcademicYear::findOrFail($id);
        $year->setCurrent();
        
        return redirect()->route('admin.academic-years')
            ->with('success', "Academic year {$year->year_name} set as current.");
    }

    /**
     * Show a specific academic year
     */
    public function show($id)
    {
        $year = AcademicYear::findOrFail($id);
        return response()->json($year);
    }

    /**
     * Update an academic year
     */
    public function update(Request $request, $id)
    {
        $year = AcademicYear::findOrFail($id);
        
        $request->validate([
            'year_name' => 'required|string|unique:academic_years,year_name,' . $id,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $year->update($request->only(['year_name', 'start_date', 'end_date']));
        
        return redirect()->route('admin.academic-years')
            ->with('success', 'Academic year updated successfully.');
    }

    /**
     * Delete an academic year
     */
    public function destroy($id)
    {
        $year = AcademicYear::findOrFail($id);
        
        // Prevent deletion of current academic year
        if ($year->is_current) {
            return redirect()->route('admin.academic-years')
                ->with('error', 'Cannot delete the current academic year.');
        }

        $yearName = $year->year_name;
        $year->delete();
        
        return redirect()->route('admin.academic-years')
            ->with('success', "Academic year {$yearName} deleted successfully.");
    }
}