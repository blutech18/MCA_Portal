<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentStatus extends Model
{
    use HasFactory;

    protected $table = 'status';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable = ['name'];
}
