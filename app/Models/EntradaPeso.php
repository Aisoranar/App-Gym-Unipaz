<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntradaPeso extends Model
{
    use HasFactory;

    protected $table = 'entradas_peso';

    protected $fillable = [
        'user_id',
        'peso_actual_kg',
        'peso_ideal_kg',
        'altura_cm',
        'imc',
        'estado_peso',
        'fecha',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}