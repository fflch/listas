<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Consulta;

class Lista extends Model
{
    use HasFactory;
    public function consultas()
    {
        return $this->belongsToMany(Consulta::class)->withTimestamps();
    }

    public function consultaOptions(){
        return Consulta::all();
    }

    public function saveConsultasLista($consultas){
        $this->consultas()->detach();
        foreach($consultas as $consulta){
            $this->consultas()->attach($consulta);
        }
    }
}
