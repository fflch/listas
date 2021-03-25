<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Consulta;
use App\Utils\Utils;
use Carbon\Carbon;

class Lista extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function consultas()
    {
        return $this->belongsToMany(Consulta::class)->withTimestamps();
    }

    public function setEmailsAllowedAttribute($value){
        $this->attributes['emails_allowed'] = Utils::trimEmails($value);
    }

    public function setEmailsAdicionaisAttribute($value){
        $this->attributes['emails_adicionais'] = Utils::trimEmails($value);
    }

    public function getStatMailmanDateAttribute($value)
    {
        if($value) return Carbon::parse($value)->format('d/m/Y H:i');;
    }
    
}
