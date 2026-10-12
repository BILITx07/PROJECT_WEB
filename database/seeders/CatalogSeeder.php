<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class CatalogSeeder extends Seeder
{
    public function run()
    {
        $items = [
            // Image 1
            ['category' => 'Tenda', 'name' => 'Tenda Kapasitas 5-6 Orang', 'price_per_day' => 40000, 'stock' => 5, 'image' => 'items/tenda_5_6.jpg'],
            ['category' => 'Tenda', 'name' => 'Tenda Kapasitas 4-5 Orang', 'price_per_day' => 35000, 'stock' => 5, 'image' => 'items/tenda_4_5.jpg'],
            ['category' => 'Tenda', 'name' => 'Tenda Kapasitas 3-4 Orang', 'price_per_day' => 30000, 'stock' => 5, 'image' => 'items/tenda_3_4.jpg'],
            ['category' => 'Tenda', 'name' => 'Tenda Kapasitas 2-3 Orang', 'price_per_day' => 25000, 'stock' => 5, 'image' => 'items/tenda_2_3.jpg'],
            ['category' => 'Tenda', 'name' => 'Tenda Ultralight Kapasitas 1-2 Orang', 'price_per_day' => 25000, 'stock' => 5, 'image' => 'items/tenda_1_2.jpg'],
            ['category' => 'Tas', 'name' => 'Tas Gunung Kapasitas 60 Liter', 'price_per_day' => 25000, 'stock' => 5, 'image' => 'items/tas_60l.jpg'],
            ['category' => 'Tas', 'name' => 'Tas Gunung Kapasitas 45 Liter', 'price_per_day' => 20000, 'stock' => 5, 'image' => 'items/tas_45l.jpg'],
            ['category' => 'Tas', 'name' => 'Tas Daypack Kapasitas 25 Liter', 'price_per_day' => 15000, 'stock' => 5, 'image' => 'items/tas_25l.jpg'],
            ['category' => 'Masak', 'name' => 'Kompor Portible Kecil Kotak / Bunga', 'price_per_day' => 8000, 'stock' => 10, 'image' => 'items/kompor_kecil.jpg'],
            ['category' => 'Masak', 'name' => 'Kompor Portible Besar', 'price_per_day' => 15000, 'stock' => 5, 'image' => 'items/kompor_besar.jpg'],
            
            // Image 2
            ['category' => 'Lainnya', 'name' => 'Sleping Bag Kantung Tidur', 'price_per_day' => 10000, 'stock' => 10, 'image' => 'items/sleeping_bag.jpg'],
            ['category' => 'Lainnya', 'name' => 'Sepatu Gunung Size 35-42', 'price_per_day' => 10000, 'stock' => 5, 'image' => 'items/sepatu_gunung.jpg'],
            ['category' => 'Lainnya', 'name' => 'Jaket Gunung Parasut & Bulang', 'price_per_day' => 10000, 'stock' => 5, 'image' => 'items/jaket_gunung.jpg'],
            ['category' => 'Lainnya', 'name' => 'Hammock Tempat Tidur Gantung', 'price_per_day' => 8000, 'stock' => 10, 'image' => 'items/hammock.jpg'],
            ['category' => 'Masak', 'name' => 'Gas Portible Isi Ulang', 'price_per_day' => 8000, 'stock' => 20, 'image' => 'items/gas_portable.jpg'],
            ['category' => 'Lainnya', 'name' => 'Jerigen Lipat Kapasitas 5L & 10L', 'price_per_day' => 5000, 'stock' => 10, 'image' => 'items/jerigen.jpg'],
            ['category' => 'Lainnya', 'name' => 'Kursi Lipat Size XL & XXL', 'price_per_day' => 15000, 'stock' => 5, 'image' => 'items/kursi_lipat.jpg'],
            ['category' => 'Lainnya', 'name' => 'Tracking Pole Tongkat Pendaki', 'price_per_day' => 10000, 'stock' => 10, 'image' => 'items/tracking_pole.jpg'],
            ['category' => 'Lainnya', 'name' => 'Meja Lipat Size XL', 'price_per_day' => 10000, 'stock' => 5, 'image' => 'items/meja_lipat.jpg'],
            ['category' => 'Tas', 'name' => 'Hydropack Kapasitas 7-10 Liter', 'price_per_day' => 10000, 'stock' => 5, 'image' => 'items/hydropack.jpg'],
            
            // Image 3
            ['category' => 'Lainnya', 'name' => 'Kacamata Warna Hitam & Silver', 'price_per_day' => 3000, 'stock' => 10, 'image' => 'items/kacamata.jpg'],
        ];

        foreach ($items as $item) {
            Item::updateOrCreate(
                ['name' => $item['name']], // find by name
                $item // update the rest (including image)
            );
        }
    }
}
