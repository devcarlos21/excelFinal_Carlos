<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CoordenadasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('coordenadas')->insert([
            [
                'celda' => 'C5',
                'fila' => 5,
                'columna' => 3,
                'destino' => 'usuario',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'celda' => 'C8',
                'fila' => 8,
                'columna' => 3,
                'destino' => 'email',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'celda' => 'C6',
                'fila' => 6,
                'columna' => 3,
                'destino' => 'cargo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'celda' => 'C7',
                'fila' => 7,
                'columna' => 3,
                'destino' => 'telefono',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
