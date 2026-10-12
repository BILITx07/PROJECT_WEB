<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class PackageSeeder extends Seeder
{
    public function run()
    {
        $packages = [
            // Paket Camping
            [
                'category' => 'Paket Camping',
                'name' => 'Paket Komplit 6 Orang',
                'price_per_day' => 190000,
                'stock' => 5,
                'image' => null,
                'description' => "1 Tenda Kapasitas 6-8 Orang\n2 Tas Gunung 45 Liter\n2 Lampu Tenda\n1 Flysheet Ukuran 3x4\n2 Kompor Portable\n2 Cooking Set\n4 Gas\n6 Matras\n1 Lampu Tumblr",
            ],
            [
                'category' => 'Paket Camping',
                'name' => 'Paket Komplit 4 Orang',
                'price_per_day' => 130000,
                'stock' => 5,
                'image' => null,
                'description' => "1 Tenda Kapasitas 4-5 Orang\n2 Tas Gunung 45 Liter\n1 Lampu Tenda\n1 Flysheet Ukuran 3x4\n1 Kompor Portable\n1 Cooking Set\n2 Gas\n4 Matras\n1 Lampu Tumblr",
            ],
            [
                'category' => 'Paket Camping',
                'name' => 'Paket Komplit 2 Orang',
                'price_per_day' => 90000,
                'stock' => 5,
                'image' => null,
                'description' => "1 Tenda Kapasitas 2-3 Orang\n1 Tas Gunung 45 Liter\n1 Lampu Tenda\n1 Flysheet Ukuran 3x4\n1 Kompor Portable\n1 Cooking Set\n1 Gas\n2 Matras\n1 Lampu Tumblr",
            ],
            [
                'category' => 'Paket Camping',
                'name' => 'Paket Hemat 6 Orang',
                'price_per_day' => 90000,
                'stock' => 5,
                'image' => null,
                'description' => "1 Tenda Kapasitas 6-8 Orang\n1 Flysheet Ukuran 3x3\n1 Kompor Portable\n1 Cooking Set\n2 Gas\n2 Matras",
            ],
            [
                'category' => 'Paket Camping',
                'name' => 'Paket Hemat 4 Orang (Tipe A)',
                'price_per_day' => 80000,
                'stock' => 5,
                'image' => null,
                'description' => "1 Tenda Kapasitas 4-5 Orang\n1 Flysheet Ukuran 3x3\n1 Kompor Portable\n1 Cooking Set\n1 Gas\n2 Matras\n4 Headlamp",
            ],
            [
                'category' => 'Paket Camping',
                'name' => 'Paket Hemat 4 Orang (Tipe B)',
                'price_per_day' => 70000,
                'stock' => 5,
                'image' => null,
                'description' => "1 Tenda Kapasitas 4-5 Orang\n1 Flysheet Ukuran 3x3\n1 Kompor Portable\n1 Cooking Set\n2 Gas\n2 Matras",
            ],
            [
                'category' => 'Paket Camping',
                'name' => 'Paket Hemat 2 Orang (Tipe A)',
                'price_per_day' => 50000,
                'stock' => 5,
                'image' => null,
                'description' => "1 Tenda Kapasitas 2-3 Orang\n1 Flysheet Ukuran 3x3\n1 Kompor Portable\n1 Cooking Set\n1 Gas\n2 Headlamp",
            ],
            [
                'category' => 'Paket Camping',
                'name' => 'Paket Hemat 2 Orang (Tipe B)',
                'price_per_day' => 50000,
                'stock' => 5,
                'image' => null,
                'description' => "1 Tenda Kapasitas 2-3 Orang\n1 Flysheet Ukuran 3x3\n1 Kompor Portable\n1 Cooking Set\n1 Gas\n2 Matras",
            ],

            // Paket Hiking
            [
                'category' => 'Paket Hiking',
                'name' => 'Paket Tektok A',
                'price_per_day' => 30000,
                'stock' => 5,
                'image' => null,
                'description' => "1 Hydropack\n1 Tracking Pole\n1 Headlamp\n1 Kacamata\n1 Sepatu",
            ],
            [
                'category' => 'Paket Hiking',
                'name' => 'Paket Tektok B',
                'price_per_day' => 50000,
                'stock' => 5,
                'image' => null,
                'description' => "1 Daypack\n1 Tracking Pole\n1 Kompor Portable\n1 Cooking Set\n1 Gas\n1 Headlamp",
            ],
        ];

        foreach ($packages as $pkg) {
            Item::updateOrCreate(
                ['name' => $pkg['name']], 
                $pkg 
            );
        }
    }
}
