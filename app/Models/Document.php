<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'document_type',
        'submitted',
        'submitted_online',
        'submitted_face_to_face',
        'document_file',
    ];

    // You can add a relation to the User model if desired:
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
