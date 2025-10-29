<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentDocument extends Model
{
    protected $fillable = [
        'enrollment_id',
        'enrollment_type',
        'document_type',
        'original_filename',
        'mime_type',
        'file_size',
        'file_data'
    ];

    protected $casts = [
        'file_size' => 'integer',
    ];

    // Hide file_data from JSON serialization to reduce response size
    protected $hidden = ['file_data'];

    /**
     * Get the file data decoded from base64
     */
    public function getDecodedFileData()
    {
        return base64_decode($this->file_data);
    }

    /**
     * Get the file data as a download response
     */
    public function getFileDownloadResponse()
    {
        $fileData = $this->getDecodedFileData();
        return response($fileData)
            ->header('Content-Type', $this->mime_type)
            ->header('Content-Disposition', 'attachment; filename="' . $this->original_filename . '"')
            ->header('Content-Length', strlen($fileData));
    }

    /**
     * Get the file data for inline viewing
     */
    public function getFileInlineResponse()
    {
        $fileData = $this->getDecodedFileData();
        return response($fileData)
            ->header('Content-Type', $this->mime_type)
            ->header('Content-Disposition', 'inline; filename="' . $this->original_filename . '"')
            ->header('Content-Length', strlen($fileData));
    }
}
