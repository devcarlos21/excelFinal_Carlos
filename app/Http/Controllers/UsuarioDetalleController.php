<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsuarioDetalle;

// use App\Models\DatosArchivo;
// use App\Models\Coordenada;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;


/**
 * @OA\Info(
 *     title="End Points de Usuarios",
 *     version="1.0.0",
 *     description="Datos extraidos de archivos excel"
 * )
 */
class UsuarioDetalleController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/usuarios-detalles/",
     *     summary="Insertar un nuevo usuario",
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
     *         description="Usuario creado exitosamente",
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
     *     summary="Obtener todos los usuarios registrados",
     *     tags={"UsuarioDetalle"},
     *     @OA\Response(
     *         response=200,
     *         description="Usuarios en la base de datos",
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
     *     summary="Obtener solor un usuario especificando su ID",
     *     tags={"UsuarioDetalle"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID del usuario"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario encontrado",
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
     *     summary="Actualizar un usuario que ya existe",
     *     tags={"UsuarioDetalle"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID del usuario"
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
     *         description="Usuario actualizado",
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
     *     summary="Eliminar un usuario especificando su ID",
     *     tags={"UsuarioDetalle"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID del usuario"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario eliminado",
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



    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $file = $request->file('file');

        try {
            // Cargar el archivo Excel
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheet = $spreadsheet->getActiveSheet();

            // Leer celdas específicas
            $usuario = $sheet->getCell('A6')->getValue(); // A6
            $email = $sheet->getCell('I11')->getValue(); // I11
            $cargo = $sheet->getCell('G14')->getValue(); // 
            $telefono = $sheet->getCell('E3')->getValue(); //

            // Guardar en la base de datos
            UsuarioDetalle::create([
                'usuario' => $usuario,
                'email' => $email,
                'cargo' => $cargo,
                'telefono' => $telefono,
            ]);

            return response()->json([
                'message' => 'Datos importados correctamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al procesar el archivo',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}