<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FichaMedica extends Model
{
    use HasFactory;

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'user_id', 
        'apellidos', 
        'nombre', 
        'fecha_nacimiento', 
        'edad', 
        'sexo', 
        'domicilio',
        'barrio', 
        'telefonos', 
        'tipo_sangre', 
        'factor_rh', 
        'lateralidad', 
        'actividad_fisica',
        'frecuencia_semanal', 
        'nombre_padre', 
        'nombre_madre', 
        'nombre_acudiente', 
        'parentesco',
        'lesiones', 
        'alergias', 
        'padece_enfermedad', 
        'enfermedad'
    ];

    /**
     * Relación con el usuario.
     * Cada ficha médica pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
