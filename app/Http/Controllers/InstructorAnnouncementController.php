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
        $instructor = Instructor::with('instructorClasses.class.section')
                            ->where('user_id', Auth::id())
                            ->firstOrFail();

        // 2) Fetch all announcements (optionally filter by class_name)
        $announcements = ClassAnnouncement::latest('created_at')->get();

        return view('instructor_announcement', compact(
            'instructor','announcements'
        ));
    }

    public function store(Request $req)
    {
        $data = $req->validate([
            'class_name' => 'required|string',
            'title'      => 'required|string|max:255',
            'message'    => 'required|string',
            'file'       => 'nullable|file|max:2048',
        ]);

        // Handle file upload
        if ($req->hasFile('file')) {
            $path = $req->file('file')->store('announcements', 'public');
            $data['file_path'] = $path;
        }

        ClassAnnouncement::create($data);

        return back()->with('success','Announcement posted');
    }
}
