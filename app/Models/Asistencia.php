<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    // Eliminamos 'rutina_id' y agregamos 'ejercicio_id'
    protected $fillable = ['user_id', 'fecha', 'ejercicio_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ejercicio()
    {
        return $this->belongsTo(Ejercicio::class);
    }
}
