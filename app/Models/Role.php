<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
    ];

    // If you have a users table and a role_user table to manage the many-to-many relationship between users and roles, you can define it like this:
    public function utilisateurs()
    {
        return $this->belongsToMany(Utilisateur::class);
    }
}
