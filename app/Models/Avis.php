<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    use HasFactory;

    protected $fillable = [
        'bouteille_id',
        'utilisateur_id',
        'commentaire',
        'note',
        // add any other fields you want to be mass assignable
    ];

    // define relationships
    public function bouteille()
    {
        return $this->belongsTo(Bouteille::class);
    }

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class);
    }
}