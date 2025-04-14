<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ejercicio extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nombre_ejercicio',
        'descripcion',
        'nivel_dificultad',
        'grupo_muscular',
        'series',
        'repeticiones',
        'calorias_aprox',
        'duracion',
        'fecha',
        'foto',
        'video',
    ];

    /**
     * Relación: cada ejercicio pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
