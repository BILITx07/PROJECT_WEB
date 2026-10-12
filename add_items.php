<?php
// Load Laravel environment
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Item;

$sourceDir = 'C:\Users\user\.gemini\antigravity-ide\brain\985341b6-c299-4407-b9e1-0f6e4bcaece1';
$destDir = __DIR__ . '/public/images/items';
if (!is_dir($destDir)) {
    mkdir($destDir, 0755, true);
}

// Mapping of generic names to generated filenames
$images = [
    'sarung_tangan' => 'sarung_tangan_gunung_1782769173045.png',
    'gaiter' => 'gaiter_sepatu_gunung_1782769184225.png',
    'kacamata' => 'kacamata_hitam_outdoor_1782769194532.png',
    'hammock' => 'hammock_single_abu_1782769203491.png',
    'sekop' => 'sekop_lipat_1782769222745.png',
    'drysack' => 'dry_sack_biru_1782769231646.png',
    'topi_rimba' => 'topi_rimba_hijau_1782769240901.png',
    'topi_abu' => 'topi_abu_muda_1782769251050.png',
    'topi_navy' => 'topi_navy_1782769268201.png'
];

foreach ($images as $key => $filename) {
    if (file_exists($sourceDir . '\\' . $filename)) {
        copy($sourceDir . '\\' . $filename, $destDir . '/' . $filename);
    }
}

$items = [
    ['name' => 'Sarung Tangan - Kilimanjaro - Warna...', 'category' => 'pakaian', 'price_per_day' => 5000, 'image' => 'images/items/' . $images['sarung_tangan']],
    ['name' => 'Gaiter - Kilimanjaro - Warna Random', 'category' => 'pakaian', 'price_per_day' => 10000, 'image' => 'images/items/' . $images['gaiter']],
    ['name' => 'Kacamata Hitam', 'category' => 'aksesoris', 'price_per_day' => 5000, 'image' => 'images/items/' . $images['kacamata']],
    ['name' => 'Sarung Tangan - Elfs - Hitam', 'category' => 'pakaian', 'price_per_day' => 7500, 'image' => 'images/items/' . $images['sarung_tangan']],
    ['name' => 'Hammock Single', 'category' => 'tenda', 'price_per_day' => 7500, 'image' => 'images/items/' . $images['hammock']],
    ['name' => 'Sekop Lipat', 'category' => 'aksesoris', 'price_per_day' => 7500, 'image' => 'images/items/' . $images['sekop']],
    ['name' => 'Dry Sack - 10L', 'category' => 'tas', 'price_per_day' => 7500, 'image' => 'images/items/' . $images['drysack']],
    ['name' => 'Dry Sack - 2L', 'category' => 'tas', 'price_per_day' => 2500, 'image' => 'images/items/' . $images['drysack']],
    ['name' => 'Topi Rimba Foldabel - Army', 'category' => 'pakaian', 'price_per_day' => 10000, 'image' => 'images/items/' . $images['topi_rimba']],
    ['name' => 'Topi Forclaz Abu Muda', 'category' => 'pakaian', 'price_per_day' => 5000, 'image' => 'images/items/' . $images['topi_abu']],
    ['name' => 'Topi Forclaz Navy', 'category' => 'pakaian', 'price_per_day' => 5000, 'image' => 'images/items/' . $images['topi_navy']],
    ['name' => 'Dry Sack - 5L', 'category' => 'tas', 'price_per_day' => 5000, 'image' => 'images/items/' . $images['drysack']],
];

foreach ($items as $item) {
    Item::firstOrCreate(
        ['name' => $item['name']],
        [
            'description' => 'Produk outdoor berkualitas tinggi.',
            'category' => $item['category'],
            'price_per_day' => $item['price_per_day'],
            'stock' => 10,
            'image' => $item['image']
        ]
    );
}

echo "Berhasil memasukkan 12 barang baru beserta fotonya ke dalam database admin!\n";
