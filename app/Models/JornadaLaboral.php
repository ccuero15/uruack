<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JornadaLaboral extends Model
{
    // En app/Models/JornadaLaboral.php
    protected $table = 'jornadas_laborales';
    public function contratos()
    {
        return $this->hasMany(Contrato::class, 'jornada_id');
    }
}
