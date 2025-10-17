<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        return view('admin_subjects', compact('subjects'));
    }

    // Store a new subject
    public function store(Request $request)
    {
        try {
            // Enhanced validation with security measures similar to siblings field
            $validated = $request->validate([
                'name' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s\-\.]+$/',
                'code' => 'required|string|max:10|regex:/^[A-Z0-9\-]+$/|unique:subjects,code',
                'is_default' => 'nullable|boolean',
            ], [
                'name.regex' => 'Subject name can only contain letters, numbers, spaces, hyphens, and periods.',
                'code.regex' => 'Subject code can only contain uppercase letters, numbers, and hyphens.',
                'code.unique' => 'This subject code already exists.',
                'code.max' => 'Subject code cannot exceed 10 characters.',
            ]);

            // Additional security: Sanitize inputs
            $sanitizedData = [
                'name' => trim(strip_tags($validated['name'])),
                'code' => strtoupper(trim($validated['code'])),
                'is_default' => (bool)($validated['is_default'] ?? false),
            ];

            // Check for duplicate names (case-insensitive)
            $existingSubject = Subject::whereRaw('LOWER(name) = ?', [strtolower($sanitizedData['name'])])->first();
            if ($existingSubject) {
                return redirect()->route('admin.subjects')
                    ->with('error', 'A subject with this name already exists.')
                    ->withInput();
            }

            Subject::create([
                'name' => $sanitizedData['name'],
                'code' => $sanitizedData['code'],
                'is_default' => $sanitizedData['is_default'],
                'subject' => $sanitizedData['name'], // Use the same value as name for backward compatibility
                'day' => 'Monday', // Default day
                'time' => '08:00:00', // Default time
                'teacher' => 'TBA', // Default teacher
            ]);

            Log::info('Subject created successfully', [
                'name' => $sanitizedData['name'],
                'code' => $sanitizedData['code'],
                'is_default' => $sanitizedData['is_default'],
                'created_by' => Auth::id()
            ]);

            return redirect()->route('admin.subjects')->with('success', 'Subject added successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Subject creation validation failed', [
                'errors' => $e->errors(),
                'request_data' => $request->except(['_token'])
            ]);
            return redirect()->route('admin.subjects')
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Subject creation failed', [
                'error' => $e->getMessage(),
                'request_data' => $request->except(['_token'])
            ]);
            return redirect()->route('admin.subjects')
                ->with('error', 'Failed to create subject. Please try again.')
                ->withInput();
        }
    }

    // in SubjectController.php

public function destroy($id)
{
    Log::debug('SubjectController@destroy called with id', ['id' => $id]);

    // force a real lookup
    $subject = Subject::findOrFail($id);
    Log::debug('Subject found', ['subject' => $subject->toArray()]);

    $deleted = $subject->delete();
    Log::debug('Subject delete() returned', ['deleted' => $deleted]);

    return redirect()
        ->route('admin.subjects')
        ->with('success', 'Subject deleted successfully!');
}

/**
 * Reset all students to have default subjects assigned
 */
public function resetDefaultSubjects()
{
    try {
        // Run the artisan command to assign default subjects to all students
        \Artisan::call('students:assign-default-subjects');
        
        $output = \Artisan::output();
        
        return redirect()
            ->route('admin.subjects')
            ->with('success', 'Default subjects have been assigned to all students successfully!');
    } catch (\Exception $e) {
        Log::error('Error resetting default subjects: ' . $e->getMessage());
        
        return redirect()
            ->route('admin.subjects')
            ->with('error', 'Error resetting default subjects: ' . $e->getMessage());
    }
}

}
