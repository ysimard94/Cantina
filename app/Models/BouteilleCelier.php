<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BouteilleCelier extends Model
{
    protected $table = 'bouteille_celier';

    protected $fillable = [
        'celier_id',
        'bouteille_id'
    ];

    public function bouteille()
    {
        return $this->belongsTo(Bouteille::class);
    }

    public function celier()
    {
        return $this->belongsTo(Celier::class);
    }
}