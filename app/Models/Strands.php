<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Strands extends Model
{
    use HasFactory;

    protected $table = 'strands';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable = ['name', 'no_of_sections'];
}
