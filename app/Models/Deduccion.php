<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deduccion extends Model
{
    use SoftDeletes;
    protected $table = 'deducciones';
    protected $fillable = ['nombre', 'tasa', 'tipo'];

    public function itemsNominaDeduccion()
    {
        return $this->hasMany(ItemNominaDeduccion::class, 'deduccion_id');
    }
}
