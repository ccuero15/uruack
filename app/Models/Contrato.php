<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contrato extends Model
{
    use HasFactory, SoftDeletes;

    // Nombre de la tabla (opcional si sigue la convención plural)
    protected $table = 'contratos';

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'empleado_id',
        'cargo_id',
        'jornada_id', // <--- Asegúrate de que esté aquí
        'fecha_inicio',
        'fecha_fin',
        'salario_base',
        'tipo_contrato',
        'estado',
    ];

    /**
     * Relación: Un contrato pertenece a un empleado.
     */
    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    /**
     * Relación: Un contrato tiene asignado un cargo.
     */
    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    /**
     * Scope opcional: Ayuda a obtener solo el contrato vigente fácilmente
     * Uso: Contrato::vigente()->get();
     */
    public function scopeVigente($query)
    {
        return $query->where('estado', 'Vigente');
    }

    public function jornada()
    {
        return $this->belongsTo(JornadaLaboral::class, 'jornada_id');
    }
}
