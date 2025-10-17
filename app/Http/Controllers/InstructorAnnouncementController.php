<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Models\ClassAnnouncement;
use Illuminate\Support\Facades\Auth;

class InstructorAnnouncementController extends Controller
{
    public function index()
    {
        // 1) Load the instructor with their classes/sections:
        $instructor = Instructor::with(['instructorClasses.class.section', 'instructorClasses.class.subject'])
                            ->where('user_id', Auth::id())
                            ->firstOrFail();

        // 2) Get unique sections from instructor's classes
        $sections = $instructor->instructorClasses
            ->pluck('class.section')
            ->filter()
            ->unique('id')
            ->values();

        // 3) Fetch announcements for this instructor's classes
        $classNames = $instructor->instructorClasses
            ->pluck('class.name')
            ->unique()
            ->toArray();
            
        $announcements = ClassAnnouncement::whereIn('class_name', $classNames)
            ->latest('created_at')
            ->get();

        return view('instructor_announcement', compact(
            'instructor', 'sections', 'announcements'
        ));
    }

    public function store(Request $req)
    {
        try {
            // Get the instructor to validate they can post to the selected section
            $instructor = Instructor::with('instructorClasses.class.section')
                                ->where('user_id', Auth::id())
                                ->firstOrFail();

            $data = $req->validate([
                'section_id' => 'required|integer|exists:section,id',
                'title'      => 'required|string|max:255',
                'message'    => 'required|string',
                'file'       => 'nullable|file|max:2048|mimes:pdf,doc,docx,jpg,jpeg,png',
            ]);

            // Get the section and find the class name
            $section = \App\Models\StudentSection::findOrFail($data['section_id']);
            
            // Find a class for this section that the instructor teaches
            $instructorClass = $instructor->instructorClasses
                ->where('class.section_id', $data['section_id'])
                ->first();
                
            if (!$instructorClass) {
                return back()->with('error', 'You are not assigned to teach any class in this section.');
            }

            $classData = [
                'class_name' => $instructorClass->class->name,
                'title'      => $data['title'],
                'message'    => $data['message'],
            ];

            // Handle file upload
            if ($req->hasFile('file')) {
                $path = $req->file('file')->store('announcements', 'public');
                $classData['file_path'] = $path;
            }

            ClassAnnouncement::create($classData);

            return back()->with('success', 'Announcement posted successfully!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error in announcement store', [
                'errors' => $e->errors(),
                'request_data' => $req->except(['_token'])
            ]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error in announcement store', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $req->except(['_token'])
            ]);
            return back()->with('error', 'An error occurred while posting the announcement. Please try again.');
        }
    }
}
