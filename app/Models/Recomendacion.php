<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recomendacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',      // Destinatario (usuario)
        'creado_por',   // Creador (entrenador o superadmin)
        'contenido', 
        'fecha'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
