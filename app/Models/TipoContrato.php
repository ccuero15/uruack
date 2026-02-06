<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoContrato extends Model
{
    // En app/Models/TipoContrato.php
    protected $table = 'tipos_contrato';
    public function contratos()
    {
        return $this->hasMany(Contrato::class, 'tipo_contrato_id');
    }
}
