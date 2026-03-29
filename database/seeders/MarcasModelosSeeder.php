<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Marca;
use App\Models\Modelo;

class MarcasModelosSeeder extends Seeder
{
    public function run(): void
    {
        $catalogo = [
            'Apple' => [
                'iPhone 17 Pro Max', 'iPhone 17 Pro', 'iPhone 17 Plus', 'iPhone 17',
                'iPhone 16 Pro Max', 'iPhone 16 Pro', 'iPhone 16 Plus', 'iPhone 16',

                'iPhone 15 Pro Max', 'iPhone 15 Pro', 'iPhone 15 Plus', 'iPhone 15',
                'iPhone 14 Pro Max', 'iPhone 14 Pro', 'iPhone 14', 'iPhone 13',
                'iPhone SE (2022)', 'iPhone 12', 'iPhone 11'
            ],
            'Samsung' => [
                'Galaxy S26 Ultra', 'Galaxy S26+', 'Galaxy S26',
                'Galaxy S25 Ultra', 'Galaxy S25+', 'Galaxy S25',

                'Galaxy S24 Ultra', 'Galaxy S24+', 'Galaxy S24',
                'Galaxy S23 Ultra', 'Galaxy S23',

                'Galaxy S22 Ultra', 'Galaxy S22+', 'Galaxy S22',
                'Galaxy S21 Ultra', 'Galaxy S21+', 'Galaxy S21',

                'Galaxy A54 5G', 'Galaxy A34 5G', 'Galaxy Z Fold 5',
                'Galaxy Z Flip 5', 'Galaxy A14', 'Galaxy M54'
            ],
            'Xiaomi' => [
                'Xiaomi 15 Pro', 'Xiaomi 15', 'Xiaomi 14 Ultra', 'Xiaomi 14', 'Xiaomi 14 Lite',

                'Redmi Note 14 Pro', 'Redmi Note 14',
                'Redmi Note 13 Pro', 'Redmi Note 13', 'Redmi 12',

                'Poco X7 Pro', 'Poco X7', 'Poco X6 Pro', 'Poco X6',

                'Xiaomi 13 Pro', 'Mi 13', 'Mi 13 Lite',

                'Redmi A3', 'Redmi A2'
            ],
            'Motorola' => [
                'Edge 50 Ultra', 'Edge 50 Pro', 'Edge 50 Fusion',
                'Edge 40 Pro', 'Edge 40',

                'Moto G85', 'Moto G84', 'Moto G73', 'Moto G54', 'Moto G34', 'Moto G24', 'Moto G14',

                'Moto E14', 'Moto E13',

                'Razr 50 Ultra', 'Razr 50', 'Razr 40 Ultra', 'Razr 40'
            ],
            'Realme' => [
                'GT 6 Pro', 'GT 6', 'GT 5 Pro', 'GT 5',

                '13 Pro+', '13 Pro', '13',
                '12 Pro+', '12 Pro', '12',

                '11 Pro+', '11 Pro', '11',

                'C67', 'C65', 'C63', 'C61', 'C55', 'C53'
            ],
            'Oppo' => [
                'Find X8 Pro', 'Find X8', 'Find X7 Ultra', 'Find X7',

                'Reno 12 Pro', 'Reno 12', 'Reno 11 Pro', 'Reno 11', 'Reno 10 Pro', 'Reno 10',

                'A99 5G', 'A98 5G', 'A79 5G', 'A78 5G', 'A58', 'A38'
            ],
        ];

        foreach ($catalogo as $nombreMarca => $modelos) {
            $marca = Marca::create([
                'nombre' => $nombreMarca,
                'es_personalizada' => false
            ]);

            foreach ($modelos as $nombreModelo) {
                Modelo::create([
                    'marca_id' => $marca->id,
                    'nombre' => $nombreModelo,
                    'es_personalizado' => false
                ]);
            }
        }
    }
}
