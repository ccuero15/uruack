<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beneficio extends Model
{
    protected $fillable = ['nombre', 'tasa', 'tipo'];

    public function itemsNominaBeneficio()
    {
        return $this->hasMany(ItemNominaBeneficio::class, 'beneficio_id');
    }
}
