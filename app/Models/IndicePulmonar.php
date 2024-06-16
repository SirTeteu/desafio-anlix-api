<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndicePulmonar extends Model
{
    public $timestamps = false;

    public function paciente() {
        return $this->belongsTo(Paciente::class);
    }
}
