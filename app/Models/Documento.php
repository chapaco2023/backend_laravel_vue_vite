<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;
    protected $table = "documentos";
    protected $fillable = ["nombre", "archivo", "persona_id"];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }
}
