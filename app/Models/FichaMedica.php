<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FichaMedica extends Model
{
    use HasFactory;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
