<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\StudentDocument;

class AdminDocumentController extends Controller
{
    /**
     * Serve document file directly from storage or database (for admin viewing enrollee documents)
     * This is a fallback method in case symbolic links aren't working
     */
    public function serveDocument(Request $request, $path)
    {
        try {
            // Security: Only allow admin users
            if (Auth::user()->user_type !== 'admin') {
                Log::info('Unauthorized access attempt', [
                    'user_id' => Auth::id(),
                    'user_type' => Auth::user()->user_type ?? 'unknown'
                ]);
                abort(403, 'Unauthorized');
            }

            // Clean the path
            $cleanPath = urldecode($path);
            $cleanPath = ltrim($cleanPath, '/');
            
            // Extract filename from path
            $filename = basename($cleanPath);
            
            // Try to find document in database first
            $document = StudentDocument::where('original_filename', $filename)
                ->orWhere('original_filename', urldecode($filename))
                ->first();
            
            if ($document) {
                // Serve from database
                return response($document->file_data)
                    ->header('Content-Type', $document->mime_type)
                    ->header('Content-Disposition', 'inline; filename="' . $document->original_filename . '"')
                    ->header('Content-Length', $document->file_size)
                    ->header('Cache-Control', 'public, max-age=3600');
            }
            
            // Fallback to file system storage
            // Only allow paths from enroll directory as a security measure
            if (!str_starts_with($cleanPath, 'enroll/')) {
                abort(403, 'Unauthorized file path');
            }

            // Verify file exists
            if (!Storage::disk('public')->exists($cleanPath)) {
                abort(404, 'File not found');
            }

            // Get file path
            $filePath = Storage::disk('public')->path($cleanPath);
            
            // Get MIME type
            $mimeType = mime_content_type($filePath);
            
            // Return file response
            return response()->file($filePath, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"',
                'Cache-Control' => 'public, max-age=3600',
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to serve admin document', [
                'path' => $path,
                'error' => $e->getMessage()
            ]);
            abort(404, 'File not found');
        }
    }
    
    /**
     * Serve document by ID from database
     * More reliable than filename lookup
     */
    public function serveDocumentById($id)
    {
        try {
            Log::info('Serving document by ID', ['id' => $id]);
            
            // Security: Only allow admin users
            if (Auth::user()->user_type !== 'admin') {
                Log::info('Unauthorized access attempt', [
                    'user_id' => Auth::id(),
                    'user_type' => Auth::user()->user_type ?? 'unknown'
                ]);
                abort(403, 'Unauthorized');
            }

            // Find document by ID
            $document = StudentDocument::findOrFail($id);
            
            Log::info('Document found', [
                'id' => $document->id,
                'filename' => $document->original_filename,
                'size' => $document->file_size,
                'has_data' => !empty($document->file_data) ? 'yes' : 'no',
                'data_length' => strlen($document->file_data)
            ]);
            
            // Check if file_data is empty
            if (empty($document->file_data)) {
                Log::error('Document file_data is empty', [
                    'id' => $document->id,
                    'filename' => $document->original_filename
                ]);
                abort(404, 'File data not found');
            }
            
            // Serve from database (decode base64)
            $fileData = base64_decode($document->file_data);
            
            return response($fileData)
                ->header('Content-Type', $document->mime_type)
                ->header('Content-Disposition', 'inline; filename="' . $document->original_filename . '"')
                ->header('Content-Length', strlen($fileData))
                ->header('Cache-Control', 'public, max-age=3600');
                
        } catch (\Exception $e) {
            Log::error('Failed to serve admin document by ID', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            abort(404, 'File not found');
        }
    }

    /**
     * Admin re-upload of enrollee document (stores in StudentDocument DB)
     */
    public function reupload(Request $request)
    {
        // Security: Only allow admin users
        if (Auth::user()->user_type !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'enrollee_id' => 'required|integer',
            'enrollment_type' => 'required|in:new,old',
            'document_type' => 'required|in:report_card,good_moral,birth_certificate,id_picture,payment_receipt,clearance',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:20480',
        ]);

        try {
            $file = $validated['file'];

            // Delete any existing document of same type for this enrollee/type
            StudentDocument::where('enrollment_id', $validated['enrollee_id'])
                ->where('enrollment_type', $validated['enrollment_type'])
                ->where('document_type', $validated['document_type'])
                ->delete();

            // Store in DB
            $doc = StudentDocument::create([
                'enrollment_id' => $validated['enrollee_id'],
                'enrollment_type' => $validated['enrollment_type'],
                'document_type' => $validated['document_type'],
                'original_filename' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'file_data' => base64_encode(file_get_contents($file->getRealPath())),
            ]);

            // Best-effort: update legacy path fields if applicable
            // We won't touch filesystems; mark as db-backed
            if ($validated['enrollment_type'] === 'new') {
                $enrollee = \App\Models\NewStudentEnrollee::find($validated['enrollee_id']);
                if ($enrollee) {
                    $fieldMap = [
                        'report_card' => 'report_card_path',
                        'good_moral' => 'good_moral_path',
                        'birth_certificate' => 'birth_certificate_path',
                        'id_picture' => 'id_picture_path',
                        'payment_receipt' => 'payment_receipt_path',
                    ];
                    if (isset($fieldMap[$validated['document_type']])) {
                        $enrollee->{$fieldMap[$validated['document_type']]} = 'db:' . $validated['document_type'];
                        $enrollee->save();
                    }
                }
            }

            if ($validated['enrollment_type'] === 'old') {
                $enrollee = \App\Models\OldStudentEnrollee::find($validated['enrollee_id']);
                if ($enrollee && $validated['document_type'] === 'payment_receipt') {
                    $enrollee->payment_receipt_path = 'db:payment_receipt';
                    $enrollee->save();
                }
            }

            return back()->with('success', 'Document re-uploaded successfully.');
        } catch (\Exception $e) {
            Log::error('Admin reupload failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->with('error', 'Failed to upload document. Please try again.');
        }
    }
}

