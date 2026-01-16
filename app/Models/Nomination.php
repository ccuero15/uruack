<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nomination extends Model
{
    use HasFactory;

    protected $fillable = ['period', 'status'];

    public function details()
    {
        return $this->hasMany(NominationDetail::class);
    }

    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }
}
