<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Cellier;
use App\Models\Archive;


class Utilisateur extends Authenticatable implements JWTSubject
{
    use  HasFactory, Notifiable;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'courriel',
        'mdp',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'mdp',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'couriel_verifie_le' => 'datetime',
    ];



    public function celliers()
    {
        return $this->hasMany(Cellier::class);
    }

    public function archives()
    {
        return $this->hasMany(Archive::class);
    }
    public function avis()
    {
        return $this->hasMany(Avis::class);
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_utilisateur');
    }
}