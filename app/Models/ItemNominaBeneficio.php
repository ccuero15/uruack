<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemNominaBeneficio extends Model
{
    protected $table = 'item_nomina_beneficio';
    protected $fillable = ['item_nomina_id', 'beneficio_id', 'monto'];

    public function itemNomina()
    {
        return $this->belongsTo(ItemNomina::class);
    }
    public function beneficio()
    {
        return $this->belongsTo(Beneficio::class);
    }
}
