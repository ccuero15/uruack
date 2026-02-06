<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReciboPago extends Model
{
    protected $table = 'recibos_pago';
    protected $fillable = ['item_nomina_id', 'fecha_emision', 'codigo_verificacion', 'ruta_pdf'];

    public function itemNomina()
    {
        return $this->belongsTo(ItemNomina::class, 'item_nomina_id');
    }
}
