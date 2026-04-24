<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rutina extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'nombre', 
        'descripcion', 
        'dias',             // Se actualiza para que coincida con el nombre en la BD
        'fecha_inicio',     // Fecha en la que inicia la rutina
        'fecha_fin',        // Fecha en la que se espera finalizar o reevaluar la rutina
        'hora_inicio',      // Hora de inicio de cada sesión
        'hora_fin',         // Hora de término de cada sesión
        'estado',           // Estado de la rutina (pendiente, en curso, finalizada)
        'objetivo',         // Meta u objetivo de la rutina (ej. ganar masa muscular)
        'intensidad',       // Intensidad (baja, media, alta)
        'notas'             // Notas o comentarios adicionales
    ];

    protected $casts = [
        'dias' => 'array',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'hora_inicio' => 'datetime:H:i',
        'hora_fin' => 'datetime:H:i',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function ejercicios()
    {
        return $this->belongsToMany(Ejercicio::class, 'ejercicio_rutina');
    }
}
