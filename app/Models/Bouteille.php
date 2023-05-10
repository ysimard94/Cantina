<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pays;
use App\Models\Categorie;
use App\Models\Cellier;
use App\Models\Archive;

class Bouteille extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'photo',
        'code_saq',
        'prix',
        'note',
        'nbr_notes',
        'pays_id',
        'categorie_id',
        'url_saq',
        'annee',
    ];

    public function pays()
    {
        return $this->belongsTo(Pays::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function celliers()
    {
        return $this->belongsToMany(Cellier::class)
                    ->withPivot('quantite')
                    ->withTimestamps();
    }

    public function archives()
    {
        return $this->hasMany(Archive::class);
    }
}