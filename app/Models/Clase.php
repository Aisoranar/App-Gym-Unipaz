<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    // Cast para que se trate is_active como booleano
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
     * (Opcional) Alias para la relación del entrenador.
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

    /**
     * Verifica si la clase ya venció, y en tal caso actualiza el estado a inactivo.
     * Combina la fecha y hora_fin para obtener el datetime final.
     */
    public function updateStatusIfExpired()
    {
        if ($this->hora_fin) {
            // Combina la fecha y la hora_fin para formar el datetime final de la clase
            $endDateTime = Carbon::parse($this->fecha . ' ' . $this->hora_fin);
            if (Carbon::now()->greaterThan($endDateTime) && $this->is_active) {
                $this->update(['is_active' => false]);
            }
        }
    }
}
