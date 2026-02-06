<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $table = [];
    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    public function tipoContrato()
    {
        return $this->belongsTo(TipoContrato::class, 'tipo_contrato_id');
    }

    public function jornada()
    {
        return $this->belongsTo(JornadaLaboral::class, 'jornada_id');
    }
}
