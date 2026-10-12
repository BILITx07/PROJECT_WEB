<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Item;
use Illuminate\Support\Str;

$items = Item::whereNull('image')->get();
$destDir = __DIR__ . '/storage/app/public/items';

if (!is_dir($destDir)) {
    mkdir($destDir, 0755, true);
}

foreach ($items as $item) {
    // Buat teks pendek dari nama (maksimal 3 kata agar muat di kotak)
    $words = explode(' ', $item->name);
    $shortName = implode(' ', array_slice($words, 0, 3));
    $encodedText = urlencode($shortName);
    
    // Tentukan warna berdasarkan kategori
    $bgColor = 'EEEEEE';
    $textColor = '333333';
    
    if (strtolower($item->category) == 'tenda') { $bgColor = 'E3F2FD'; $textColor = '1565C0'; }
    if (strtolower($item->category) == 'pakaian') { $bgColor = 'FCE4EC'; $textColor = 'C2185B'; }
    if (strtolower($item->category) == 'tas') { $bgColor = 'E8F5E9'; $textColor = '2E7D32'; }
    if (strtolower($item->category) == 'alat masak') { $bgColor = 'FFF3E0'; $textColor = 'EF6C00'; }
    if (strtolower($item->category) == 'perlengkapan') { $bgColor = 'F3E5F5'; $textColor = '6A1B9A'; }
    
    $url = "https://placehold.co/400x400/{$bgColor}/{$textColor}/png?text={$encodedText}";
    
    // Download gambar placeholder
    $imageContent = @file_get_contents($url);
    
    if ($imageContent) {
        $filename = 'placeholder_' . Str::slug($item->name) . '_' . time() . '.png';
        file_put_contents($destDir . '/' . $filename, $imageContent);
        
        $item->image = 'items/' . $filename;
        $item->save();
        echo "Berhasil membuat gambar untuk: " . $item->name . "\n";
    } else {
        echo "Gagal mengunduh untuk: " . $item->name . "\n";
    }
}
echo "Selesai!";
