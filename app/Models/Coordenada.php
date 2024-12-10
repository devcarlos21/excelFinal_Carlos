<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordenada extends Model
{
    use HasFactory;

    // Aquí puedes especificar las propiedades fillable si es necesario
    protected $fillable = ['celda', 'fila', 'columna', 'destino'];
}
