<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    public $timestamps = false;

    public function cardiacoIndices() {
        return $this->hasMany(IndiceCardiaco::class);
    }

    public function pulmonarIndices() {
        return $this->hasMany(IndicePulmonar::class);
    }

    public function latestCardiacoIndice() {
        return $this->hasOne(IndiceCardiaco::class)
            ->orderBy('data', 'desc')
            ->orderBy('id', 'desc');
    }

    public function latestPulmonarIndice() {
        return $this->hasOne(IndicePulmonar::class)
            ->orderBy('data', 'desc')
            ->orderBy('id', 'desc');
    }
}
