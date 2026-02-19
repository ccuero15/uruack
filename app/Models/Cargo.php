<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cargo extends Model
{
    use SoftDeletes;
    public function contratos()
    {
        return $this->hasMany(Contrato::class, 'cargo_id');
    }
}
