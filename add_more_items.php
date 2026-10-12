<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Item;

$items = [
    ['name' => 'Jas Hujan Ponco Multifungsi - Merk &...', 'category' => 'Pakaian', 'price_per_day' => 10000],
    ['name' => 'Tiang Flysheet - Besi', 'category' => 'Tenda', 'price_per_day' => 10000],
    ['name' => 'Tiang Flysheet - Alumunium', 'category' => 'Tenda', 'price_per_day' => 10000],
    
    ['name' => 'Forclaz MT50 Black - L', 'category' => 'Pakaian', 'price_per_day' => 30000],
    ['name' => 'Forclaz MT50 Black - M', 'category' => 'Pakaian', 'price_per_day' => 30000],
    ['name' => 'Forclaz MT50 Black - XL', 'category' => 'Pakaian', 'price_per_day' => 30000],
    ['name' => 'Salewa Women\'s Fleece - S', 'category' => 'Pakaian', 'price_per_day' => 20000],
    ['name' => 'Lowe Alpine Fleece Women - S', 'category' => 'Pakaian', 'price_per_day' => 20000],
    ['name' => 'Jack Wolfskin Polar Womens XL - Tosca', 'category' => 'Pakaian', 'price_per_day' => 20000],
    ['name' => 'Jack Wolfskin Polar Womens L - UNGU', 'category' => 'Pakaian', 'price_per_day' => 20000],
    ['name' => 'Jack Wolfskin Polar Womens XXL - Pink', 'category' => 'Pakaian', 'price_per_day' => 20000],
    
    ['name' => 'Koper 20 Inci Supercase Abs Tsa Lock - Cokelat', 'category' => 'Tas', 'price_per_day' => 15000],
    ['name' => 'Koper 20 Inci Supercase Abs Tsa Lock - Cherry...', 'category' => 'Tas', 'price_per_day' => 15000],
    ['name' => 'Koper 24 Inci Supercase Abs Tsa Lock - Orange', 'category' => 'Tas', 'price_per_day' => 15000],
    ['name' => 'Koper 24 Inci Supercase Abs Tsa Lock - Hijau...', 'category' => 'Tas', 'price_per_day' => 15000],
    ['name' => 'Koper 24 Inci Supercase Mochi Koper Tsa Lock -...', 'category' => 'Tas', 'price_per_day' => 15000],
    
    ['name' => 'Headlamp - Taff - Hitam', 'category' => 'Perlengkapan', 'price_per_day' => 7500],
    ['name' => 'Headlamp - Taff - abu', 'category' => 'Perlengkapan', 'price_per_day' => 7500],
    ['name' => 'Lampu Tenda G198', 'category' => 'Tenda', 'price_per_day' => 7500],
    ['name' => 'Lampu Tenda Camping - Warna Random', 'category' => 'Tenda', 'price_per_day' => 5000],
    ['name' => 'Lampu Tenda Alltrek', 'category' => 'Tenda', 'price_per_day' => 10000],
    ['name' => 'Lampu Tenda - Bakpao - Battrey', 'category' => 'Tenda', 'price_per_day' => 5000],
    ['name' => 'Senter - Battery - Biru', 'category' => 'Perlengkapan', 'price_per_day' => 5000],
    ['name' => 'Senter - Recharge - Putih', 'category' => 'Perlengkapan', 'price_per_day' => 7500],
    
    ['name' => 'BBQ Charcoal Arang', 'category' => 'Alat Masak', 'price_per_day' => 15000],
    ['name' => 'Nesting All Trek - Steamed Tray...', 'category' => 'Alat Masak', 'price_per_day' => 10000],
    ['name' => 'Pisau Lipat Tebal', 'category' => 'Perlengkapan', 'price_per_day' => 5000]
];

foreach ($items as $item) {
    Item::firstOrCreate(
        ['name' => $item['name']],
        [
            'description' => 'Produk outdoor dan travel terbaik.',
            'category' => $item['category'],
            'price_per_day' => $item['price_per_day'],
            'stock' => 10,
            'image' => null // Akan tampil sebagai emoji kategori di admin
        ]
    );
}

// Untuk Jas Hujan Ponco yang fotonya berhasil dibuat sebelum limit
$jasHujan = Item::where('name', 'Jas Hujan Ponco Multifungsi - Merk &...')->first();
if ($jasHujan) {
    $sourceDir = 'C:\Users\user\.gemini\antigravity-ide\brain\985341b6-c299-4407-b9e1-0f6e4bcaece1';
    $destDir = __DIR__ . '/storage/app/public/items';
    $filename = 'jas_hujan_ponco_1782769805397.png';
    if (file_exists($sourceDir . '\\' . $filename)) {
        copy($sourceDir . '\\' . $filename, $destDir . '/' . $filename);
        $jasHujan->image = 'items/' . $filename;
        $jasHujan->save();
    }
}

echo "27 Barang berhasil dimasukkan!";
