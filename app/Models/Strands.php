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

    protected $fillable = ['name', 'no_of_sections', 'capacity', 'enrolled_count'];

    public function getAvailableSlotsAttribute(): int
    {
        $capacity = (int) ($this->capacity ?? 0);
        $enrolled = (int) ($this->enrolled_count ?? 0);
        $available = $capacity - $enrolled;
        return $available > 0 ? $available : 0;
    }

    public function getIsFullAttribute(): bool
    {
        return ($this->enrolled_count ?? 0) >= ($this->capacity ?? 0);
    }
}
