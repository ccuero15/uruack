<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cargo extends Model
{
    use SoftDeletes;
    protected $fillable = ['titulo', 'departamento', 'salario_referencial'];

    public function contratos()
    {
        return $this->hasMany(Contrato::class, 'cargo_id');
    }
}
