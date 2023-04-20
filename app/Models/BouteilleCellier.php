<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BouteilleCellier extends Model
{
    protected $table = 'bouteille_cellier';

    protected $fillable = [
        'cellier_id',
        'bouteille_id'
    ];

    public function bouteille()
    {
        return $this->belongsTo(Bouteille::class);
    }

    public function cellier()
    {
        return $this->belongsTo(Cellier::class);
    }
}
