<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enrollment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'semester',
        'grade_level',
        'status',
        'strand',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'dob',
        'contact',
        'email',
    ];
}
