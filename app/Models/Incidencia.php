<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Incidencia extends Model
{
    use SoftDeletes;
    protected $fillable = ['empleado_id', 'tipo_incidencia_id', 'fecha_inicio', 'fecha_fin', 'horas_extras', 'observacion'];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
    public function tipoIncidencia()
    {
        return $this->belongsTo(TipoIncidencia::class, 'tipo_incidencia_id');
    }
}
