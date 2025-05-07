<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'role'
    ];

    // Campos que se ocultan en la serialización
    protected $hidden = [
        'password', 
        'remember_token',
    ];

    // Convertir a tipo de dato nativo
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relación a fichas médicas.
     * Aunque en nuestra lógica cada usuario sólo debería tener una ficha médica,
     * se define como hasMany para permitir consultas en el futuro y mantener la integridad relacional.
     */
    public function fichas()
    {
        return $this->hasMany(FichaMedica::class);
    }

    /**
     * Relación a las clases en las que el usuario está inscrito.
     */
    public function clasesParticipadas()
    {
        return $this->belongsToMany(Clase::class, 'clase_user')->withTimestamps();
    }

    /**
     * Relación a las clases (participaciones) en las que el usuario está inscrito.
     */
    public function participaciones()
    {
        return $this->belongsToMany(\App\Models\Clase::class, 'clase_user')->withTimestamps();
    }
}
