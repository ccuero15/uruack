<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    protected $fillable = ['nomination_id', 'employee_id', 'description'];

    public function nomination()
    {
        return $this->belongsTo(Nomination::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
