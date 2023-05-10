<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class archive extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'bouteille_id',
        'utilisateur_id',
    ];

    /**
     * Get the bouteille that was consumed in this archive.
     */

    public function bouteille()
    {
        return $this->belongsTo(Bouteille::class);
    }

    /**
     * Get the user that consumed the bouteille in this archive.
     */
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class);
    }
}
