<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassAnnouncement;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        
        $className = Auth::user()->class->name; // Returns "STEM"
        $announcements = ClassAnnouncement::where('class_name', $className)->get();
        $notificationCount = $announcements->count();

        return view('student_dash', compact('notificationCount', 'announcements'));
    }
}
