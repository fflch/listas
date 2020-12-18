<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lista;
class Consulta extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function listas()
    {
        return $this->belongsToMany(Lista::class)->withTimestamps();
    }
}
