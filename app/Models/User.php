<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'role'
    ];

    protected $hidden = [
        'password', 
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

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
}
