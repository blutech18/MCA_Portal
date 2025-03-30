<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function uploadOnline(Request $request)
    {
        // Validate the file upload along with the document type (if needed)
        $validated = $request->validate([
            'document_type' => 'required|string',
            'document_file' => 'required|file|mimes:pdf,jpg,jpeg,png', // adjust allowed types
        ]);

        $user = Auth::user();

        // Handle file upload
        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            // Store file in the public folder (e.g., public/documents)
            $path = $file->store('documents', 'public');
        } else {
            $path = null;
        }

        // Create or update a document record for this user and document type
        $document = Document::updateOrCreate(
            [
                'user_id' => $user->id,
                'document_type' => $validated['document_type'],
            ],
            [
                'submitted' => 'yes',
                'submitted_online' => 'yes',
                'submitted_face_to_face' => 'no', // or keep as is
                'document_file' => $path,
            ]
        );

        return redirect()->back()->with('success', 'Document uploaded successfully!');
    }
    
    // Optional: a method to view the document file
    public function viewDocument($id)
    {
        $document = Document::findOrFail($id);
        // Return the file URL or a view that displays the document
        // For example:
        return response()->file(public_path('storage/' . $document->document_file));
    }
}
