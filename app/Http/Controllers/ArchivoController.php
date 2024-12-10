<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Coordenada;
use App\Models\DatosArchivo;

class ArchivoController extends Controller
{
    //
    public function subir(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:xlsx',
        ]);
    
        $archivo = $request->file('archivo');
        $datosExcel = Excel::toArray([], $archivo);
    
        $coordenadas = Coordenada::all();
        $datos = new DatosArchivo();
    
        foreach ($coordenadas as $coord) {
            $fila = $coord->fila - 1;
            $columna = $coord->columna - 1;
            $valor = $datosExcel[0][$fila][$columna] ?? null;
            $datos->{$coord->destino} = $valor;
        }
    
        $datos->save();
    
        return back()->with('success', 'Archivo procesado y datos guardados.');
    }
    
}



