<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Beneficio extends Model
{
    use SoftDeletes;
    protected $fillable = ['nombre', 'tasa', 'tipo'];

    public function itemsNominaBeneficio()
    {
        return $this->hasMany(ItemNominaBeneficio::class, 'beneficio_id');
    }
}
