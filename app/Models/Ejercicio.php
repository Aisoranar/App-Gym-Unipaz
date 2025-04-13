<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ejercicio extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'nombre_ejercicio', 'descripcion', 'series',
        'repeticiones', 'duracion', 'fecha'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function rutinas()
    {
        return $this->belongsToMany(Rutina::class, 'ejercicio_rutina');
    }
}
