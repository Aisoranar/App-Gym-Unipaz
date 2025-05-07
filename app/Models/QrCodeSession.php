<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrCodeSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nombre',
        'activo',
        'codigo',
    ];

    // Relación: una sesión QR pertenece a un entrenador (usuario)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación: una sesión QR tiene muchos escaneos
    public function scans()
    {
        return $this->hasMany(QrScan::class);
    }
}
