<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeLevel extends Model
{
    use HasFactory;

    protected $table = 'grade_level';

    protected $primaryKey = 'grade_level_id';

    public $incrementing = true;

    protected $fillable = ['name'];
}
