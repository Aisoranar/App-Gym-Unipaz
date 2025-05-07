<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrScan extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'qr_code_session_id',
        'carrera',
        'actividad',
        'fecha',
    ];

    // Relación: un escaneo pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Relación: un escaneo pertenece a una sesión QR
    public function session()
    {
        return $this->belongsTo(QrCodeSession::class, 'qr_code_session_id');
    }
}
