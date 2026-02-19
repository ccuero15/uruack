<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empleado extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'cedula',
        'nombre',
        'apellido',
        'email',
        'fecha_ingreso',
        'estado'
    ];

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
