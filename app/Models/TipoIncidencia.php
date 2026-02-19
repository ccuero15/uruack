<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoIncidencia extends Model
{
    use SoftDeletes;
    protected $table = 'tipos_incidencia';
    protected $fillable = ['nombre', 'afecta_pago', 'tipo_ajuste', 'factor'];

    public function incidencias()
    {
        return $this->hasMany(Incidencia::class, 'tipo_incidencia_id');
    }
}
