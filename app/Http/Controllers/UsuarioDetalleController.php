<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsuarioDetalle;

/**
 * @OA\Info(
 *     title="End Points para los datos de Excel",
 *     version="1.0.0",
 *     description="API para gestionar detalles de usuarios"
 * )
 */
class UsuarioDetalleController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/usuarios-detalles/",
     *     summary="Insertar un nuevo UsuarioDetalle",
     *     tags={"UsuarioDetalle"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"usuario", "email"},
     *             @OA\Property(property="usuario", type="string", description="Nombre del usuario"),
     *             @OA\Property(property="email", type="string", format="email", description="Correo electrónico del usuario"),
     *             @OA\Property(property="cargo", type="string", description="Cargo del usuario"),
     *             @OA\Property(property="telefono", type="string", description="Teléfono del usuario")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="UsuarioDetalle creado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", description="ID del UsuarioDetalle"),
     *             @OA\Property(property="usuario", type="string", description="Nombre del usuario"),
     *             @OA\Property(property="email", type="string", description="Correo electrónico del usuario"),
     *             @OA\Property(property="cargo", type="string", description="Cargo del usuario"),
     *             @OA\Property(property="telefono", type="string", description="Teléfono del usuario"),
     *         )
     *     )
     * )
     */
    public function insertarUsuarioDetalle(Request $request)
    {
        $validatedData = $request->validate([
            'usuario' => 'required|string|unique:usuarios_detalles,usuario',
            'email' => 'required|email|unique:usuarios_detalles,email',
            'cargo' => 'nullable|string',
            'telefono' => 'nullable|string',
        ]);

        $usuarioDetalle = UsuarioDetalle::create($validatedData);

        return response()->json($usuarioDetalle);
    }

    /**
     * @OA\Get(
     *     path="/api/usuarios-detalles",
     *     summary="Obtener todos los registros de UsuarioDetalle",
     *     tags={"UsuarioDetalle"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de UsuarioDetalle",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/UsuarioDetalle")
     *         )
     *     )
     * )
     */
    public function obtenerUsuariosDetalles()
    {
        return response()->json(UsuarioDetalle::all());
    }

    /**
     * @OA\Get(
     *     path="/api/usuarios-detalles/{id}",
     *     summary="Obtener un UsuarioDetalle por su ID",
     *     tags={"UsuarioDetalle"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID del UsuarioDetalle"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="UsuarioDetalle encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/UsuarioDetalle")
     *     )
     * )
     */
    public function obtenerUsuarioDetalle($id)
    {
        $usuarioDetalle = UsuarioDetalle::findOrFail($id);
        return response()->json($usuarioDetalle);
    }

    /**
     * @OA\Put(
     *     path="/api/usuarios-detalles/{id}",
     *     summary="Actualizar un UsuarioDetalle existente",
     *     tags={"UsuarioDetalle"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID del UsuarioDetalle"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="usuario", type="string", description="Nombre del usuario"),
     *             @OA\Property(property="email", type="string", description="Correo electrónico del usuario"),
     *             @OA\Property(property="cargo", type="string", description="Cargo del usuario"),
     *             @OA\Property(property="telefono", type="string", description="Teléfono del usuario")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="UsuarioDetalle actualizado",
     *         @OA\JsonContent(ref="#/components/schemas/UsuarioDetalle")
     *     )
     * )
     */
    public function actualizarUsuarioDetalle(Request $request, $id)
    {
        $usuarioDetalle = UsuarioDetalle::findOrFail($id);

        $validatedData = $request->validate([
            'usuario' => 'sometimes|string|unique:usuarios_detalles,usuario,' . $id,
            'email' => 'sometimes|email|unique:usuarios_detalles,email,' . $id,
            'cargo' => 'nullable|string',
            'telefono' => 'nullable|string',
        ]);

        $usuarioDetalle->update($validatedData);

        return response()->json($usuarioDetalle);
    }

    /**
     * @OA\Delete(
     *     path="/api/usuarios-detalles/{id}",
     *     summary="Eliminar un UsuarioDetalle por su ID",
     *     tags={"UsuarioDetalle"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID del UsuarioDetalle"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="UsuarioDetalle eliminado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="UsuarioDetalle eliminado exitosamente")
     *         )
     *     )
     * )
     */
    public function eliminarUsuarioDetalle($id)
    {
        $usuarioDetalle = UsuarioDetalle::findOrFail($id);
        $usuarioDetalle->delete();

        return response()->json(['message' => 'UsuarioDetalle eliminado exitosamente']);
    }
}
