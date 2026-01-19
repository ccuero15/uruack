<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'last_name', 'dni', 'position', 'base_salary', 'active'];

    public function nominationDetails()
    {
        return $this->hasMany(NominationDetail::class);
    }

    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }

    public function position()
{
    return $this->belongsTo(Position::class, 'position', 'id');
}
}
