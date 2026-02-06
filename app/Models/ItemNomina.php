<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemNomina extends Model
{
    protected $table = 'item_nomina';
    protected $fillable = ['ejecucion_id', 'empleado_id', 'salario_bruto', 'total_deducciones', 'total_beneficios', 'salario_neto'];

    // Relaciones
    public function ejecucion()
    {
        return $this->belongsTo(EjecucionNomina::class, 'ejecucion_id');
    }
    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
    public function detallesDeducciones()
    {
        return $this->hasMany(ItemNominaDeduccion::class, 'item_nomina_id');
    }
    public function detallesBeneficios()
    {
        return $this->hasMany(ItemNominaBeneficio::class, 'item_nomina_id');
    }
    public function recibo()
    {
        return $this->hasOne(ReciboPago::class, 'item_nomina_id');
    }
}
