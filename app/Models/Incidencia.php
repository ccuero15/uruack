<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
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
