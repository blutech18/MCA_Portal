<?php

namespace App\Models;

use App\Models\CoreValueEvaluation;
use Illuminate\Database\Eloquent\Model;

class CoreValue extends Model
{
    protected $fillable = ['name','slug'];

    public function evaluations()
    {
        return $this->hasMany(CoreValueEvaluation::class);
    }
}
