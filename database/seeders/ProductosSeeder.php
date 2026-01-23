<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductosSeeder extends Seeder
{
    public function run()
    {
        $catHardware = '69728e94dd142362cc0309e2';
        $catAlmacenamiento = '69728ea2dd142362cc0309e4';
        $catPerifericos = '69728e9bdd142362cc0309e3';

        $productos = [
            ['n' => 'Procesador Intel Core i3 12100F', 'p' => 420, 'c' => $catHardware],
            ['n' => 'Procesador Intel Core i5 13400F', 'p' => 950, 'c' => $catHardware],
            ['n' => 'Procesador Intel Core i7 13700K', 'p' => 1850, 'c' => $catHardware],
            ['n' => 'Procesador AMD Ryzen 5 5600G', 'p' => 580, 'c' => $catHardware],
            ['n' => 'Procesador AMD Ryzen 7 5700X', 'p' => 890, 'c' => $catHardware],
            ['n' => 'Procesador AMD Ryzen 9 7900X', 'p' => 2100, 'c' => $catHardware],
            ['n' => 'Placa Madre ASUS Prime B550M-A WiFi', 'p' => 450, 'c' => $catHardware],
            ['n' => 'Placa Madre Gigabyte B660M DS3H', 'p' => 520, 'c' => $catHardware],
            ['n' => 'Placa Madre MSI MAG Z790 Tomahawk', 'p' => 1300, 'c' => $catHardware],
            ['n' => 'Placa Madre ASRock B450M Steel Legend', 'p' => 380, 'c' => $catHardware],
            ['n' => 'Memoria RAM Kingston Fury 8GB 3200MHz', 'p' => 110, 'c' => $catHardware],
            ['n' => 'Memoria RAM Corsair Vengeance 16GB (2x8) 3600MHz', 'p' => 280, 'c' => $catHardware],
            ['n' => 'Memoria RAM TeamGroup T-Force 32GB (2x16) RGB', 'p' => 450, 'c' => $catHardware],
            ['n' => 'Tarjeta de Video NVIDIA RTX 3060 12GB', 'p' => 1350, 'c' => $catHardware],
            ['n' => 'Tarjeta de Video NVIDIA RTX 4060 8GB', 'p' => 1480, 'c' => $catHardware],
            ['n' => 'Tarjeta de Video NVIDIA RTX 4070 Ti', 'p' => 3800, 'c' => $catHardware],
            ['n' => 'Tarjeta de Video AMD Radeon RX 6600 8GB', 'p' => 980, 'c' => $catHardware],
            ['n' => 'Tarjeta de Video AMD Radeon RX 7600', 'p' => 1250, 'c' => $catHardware],
            ['n' => 'Fuente de Poder 500W 80+ White', 'p' => 180, 'c' => $catHardware],
            ['n' => 'Fuente de Poder Corsair CV650 650W Bronze', 'p' => 260, 'c' => $catHardware],
            ['n' => 'Fuente de Poder Gold 750W Modular', 'p' => 480, 'c' => $catHardware],
            ['n' => 'Fuente de Poder ROG Thor 850W Platinum', 'p' => 950, 'c' => $catHardware],
            ['n' => 'Case Gamer Antryx RX 350 Black', 'p' => 190, 'c' => $catHardware],
            ['n' => 'Case NZXT H5 Flow RGB', 'p' => 450, 'c' => $catHardware],
            ['n' => 'Disipador CPU Cooler Master Hyper 212', 'p' => 150, 'c' => $catHardware],
            ['n' => 'Refrigeración Líquida 240mm RGB', 'p' => 380, 'c' => $catHardware],
            ['n' => 'SSD Kingston A400 480GB SATA', 'p' => 140, 'c' => $catAlmacenamiento],
            ['n' => 'SSD Crucial BX500 1TB SATA', 'p' => 260, 'c' => $catAlmacenamiento],
            ['n' => 'SSD M.2 NVMe WD Blue SN570 500GB', 'p' => 180, 'c' => $catAlmacenamiento],
            ['n' => 'SSD M.2 NVMe Kingston NV2 1TB', 'p' => 240, 'c' => $catAlmacenamiento],
            ['n' => 'SSD M.2 NVMe Samsung 980 Pro 1TB', 'p' => 450, 'c' => $catAlmacenamiento],
            ['n' => 'SSD M.2 NVMe WD Black SN850X 2TB', 'p' => 780, 'c' => $catAlmacenamiento],
            ['n' => 'Disco Duro HDD Seagate Barracuda 1TB', 'p' => 190, 'c' => $catAlmacenamiento],
            ['n' => 'Disco Duro HDD WD Blue 2TB', 'p' => 280, 'c' => $catAlmacenamiento],
            ['n' => 'Disco Duro HDD Toshiba Surveillance 4TB', 'p' => 450, 'c' => $catAlmacenamiento],
            ['n' => 'Disco Externo Toshiba Canvio 1TB USB 3.0', 'p' => 210, 'c' => $catAlmacenamiento],
            ['n' => 'Monitor Samsung 24" IPS 75Hz', 'p' => 480, 'c' => $catPerifericos],
            ['n' => 'Monitor LG UltraGear 27" 144Hz 1ms', 'p' => 950, 'c' => $catPerifericos],
            ['n' => 'Monitor Curvo Teros 24" 165Hz', 'p' => 550, 'c' => $catPerifericos],
            ['n' => 'Teclado Mecánico Redragon Kumara K552', 'p' => 160, 'c' => $catPerifericos],
            ['n' => 'Teclado Membrana Logitech G213 RGB', 'p' => 190, 'c' => $catPerifericos],
            ['n' => 'Teclado Inalámbrico Logitech K400 Plus', 'p' => 110, 'c' => $catPerifericos],
            ['n' => 'Mouse Logitech G203 Lightsync', 'p' => 95, 'c' => $catPerifericos],
            ['n' => 'Mouse Gamer Razer DeathAdder Essential', 'p' => 120, 'c' => $catPerifericos],
            ['n' => 'Mouse Inalámbrico Logitech G305', 'p' => 180, 'c' => $catPerifericos],
            ['n' => 'Audífonos HyperX Cloud Stinger 2', 'p' => 170, 'c' => $catPerifericos],
            ['n' => 'Audífonos Logitech G435 Inalámbricos', 'p' => 280, 'c' => $catPerifericos],
            ['n' => 'Audífonos VSG Singularity Z 7.1', 'p' => 140, 'c' => $catPerifericos],
            ['n' => 'Cámara Web Logitech C920 Pro HD', 'p' => 290, 'c' => $catPerifericos],
            ['n' => 'Mousepad XL Diseño Mapa Mundi', 'p' => 35, 'c' => $catPerifericos],
            ['n' => 'Silla Gamer Ergonómica Reclinable', 'p' => 450, 'c' => $catPerifericos],
        ];

        foreach ($productos as $prod) {
            $exists = Producto::where('nombre', $prod['n'])->exists();

            if (!$exists) {
                Producto::create([
                    'nombre' => $prod['n'],
                    'precio' => $prod['p'],
                    'stock' => rand(3, 25),
                    'categoria_id' => $prod['c'],
                    'imagen' => null,
                    'codigo_barras' => str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                ]);
            }
        }
    }
}
