<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemNominaDeduccion extends Model
{
    protected $table = 'item_nomina_deduccion';
    protected $fillable = ['item_nomina_id', 'deduccion_id', 'monto', 'descripcion'];

    public function itemNomina()
    {
        return $this->belongsTo(ItemNomina::class);
    }
    public function deduccion()
    {
        return $this->belongsTo(Deduccion::class);
    }
}
