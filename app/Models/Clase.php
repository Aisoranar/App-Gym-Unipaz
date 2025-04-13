<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'titulo', 
        'descripcion', 
        'objetivos',
        'fecha', 
        'hora_inicio', 
        'hora_fin',
        'nivel',
        'max_participantes',
        'imagen',
        'is_active' 
    ];

    // Se agrega el cast para que is_active se maneje como booleano
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relación con el usuario creador (entrenador o superadmin)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * (Opcional) Alias para la relación del entrenador, para usar en las vistas.
     */
    public function entrenador()
    {
        return $this->user();
    }

    /**
     * Relación many-to-many con usuarios participantes (para rol "usuario")
     */
    public function participants()
    {
        return $this->belongsToMany(User::class, 'clase_user')->withTimestamps();
    }
}
