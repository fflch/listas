<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;
    public function listas()
    {
        return $this->belongsToMany('App\Models\Lista')->withTimestamps();
    }
}
