<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EjecucionNomina extends Model
{
    protected $table = 'ejecucion_nomina';
    protected $fillable = ['periodo_inicio', 'periodo_fin', 'fecha_ejecucion', 'estado'];

    public function items()
    {
        return $this->hasMany(ItemNomina::class, 'ejecucion_id');
    }
}
