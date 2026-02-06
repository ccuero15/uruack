<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    public function contratos()
    {
        return $this->hasMany(Contrato::class, 'empleado_id');
    }

    public function incidencias()
    {
        return $this->hasMany(Incidencia::class, 'empleado_id');
    }

    public function itemsNomina()
    {
        return $this->hasMany(ItemNomina::class, 'empleado_id');
    }
}
