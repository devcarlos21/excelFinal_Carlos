<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *     schema="Información de Usuarios",
 *     type="object",
 *     required={"usuario", "email"},
 *     @OA\Property(property="id", type="integer", description="ID del UsuarioDetalle"),
 *     @OA\Property(property="usuario", type="string", description="Nombre del usuario"),
 *     @OA\Property(property="email", type="string", format="email", description="Correo electrónico del usuario"),
 *     @OA\Property(property="cargo", type="string", description="Cargo del usuario"),
 *     @OA\Property(property="telefono", type="string", description="Teléfono del usuario"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Fecha de creación"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Fecha de última actualización")
 * )
 */


class UsuarioDetalle extends Model
{
    use HasFactory;

    // Especificar el nombre de la tabla (opcional si sigue las convenciones de Laravel)
    protected $table = 'usuarios_detalles';

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'usuario',
        'email',
        'cargo',
        'telefono',
    ];
}
