<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';
    public $incrementing = true; // ensure auto-increment works
    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'username',
        'password',
        'user_type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // Remove if you dropped it
            'password' => 'hashed',
        ];
    }

    // Override to use 'user_id' instead of 'id' for authentication
    public function getAuthIdentifierName()
    {
        return 'user_id';
    }
    
    public function instructor()
    {
        // user_id is your PK on users, and user_id FK on instructors
        return $this->hasOne(Instructor::class, 'user_id', 'user_id');
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'user_id');
    }
}
