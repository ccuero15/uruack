<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    public function contratos()
    {
        return $this->hasMany(Contrato::class, 'cargo_id');
    }
}
