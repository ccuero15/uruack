<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deduccion extends Model
{
    protected $table = 'deducciones';
    protected $fillable = ['nombre', 'tasa', 'tipo'];

    public function itemsNominaDeduccion()
    {
        return $this->hasMany(ItemNominaDeduccion::class, 'deduccion_id');
    }
}
