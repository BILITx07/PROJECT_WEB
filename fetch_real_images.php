<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Item;
use Illuminate\Support\Str;

$items = Item::where('image', 'like', '%placeholder_%')->get();
$destDir = __DIR__ . '/storage/app/public/items';

foreach ($items as $item) {
    $keyword = 'camping';
    $name = strtolower($item->name);
    
    if (strpos($name, 'tiang') !== false) { $keyword = 'pole'; }
    elseif (strpos($name, 'forclaz') !== false || strpos($name, 'fleece') !== false || strpos($name, 'polar') !== false) { $keyword = 'jacket,winter'; }
    elseif (strpos($name, 'koper') !== false) { $keyword = 'suitcase,luggage'; }
    elseif (strpos($name, 'headlamp') !== false) { $keyword = 'headlamp'; }
    elseif (strpos($name, 'senter') !== false) { $keyword = 'flashlight'; }
    elseif (strpos($name, 'lampu tenda') !== false) { $keyword = 'lantern,camping'; }
    elseif (strpos($name, 'bbq') !== false) { $keyword = 'bbq,grill'; }
    elseif (strpos($name, 'nesting') !== false) { $keyword = 'camping,cooking'; }
    elseif (strpos($name, 'pisau') !== false) { $keyword = 'knife'; }
    
    $url = "https://loremflickr.com/400/400/" . urlencode($keyword);
    
    $opts = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n",
            "follow_location" => 1
        ]
    ];
    $context = stream_context_create($opts);
    
    $imageContent = @file_get_contents($url, false, $context);
    
    if ($imageContent && strlen($imageContent) > 2000) { 
        $filename = 'real_' . Str::slug($item->name) . '_' . time() . '.jpg';
        file_put_contents($destDir . '/' . $filename, $imageContent);
        
        // Hapus placeholder lama
        $oldFile = str_replace('items/', '', $item->image);
        if(file_exists($destDir . '/' . $oldFile)) {
            @unlink($destDir . '/' . $oldFile);
        }
        
        $item->image = 'items/' . $filename;
        $item->save();
        echo "Berhasil mengunduh foto asli untuk: " . $item->name . " (Katakunci: $keyword)\n";
    } else {
        echo "Gagal mengunduh foto untuk: " . $item->name . "\n";
    }
}
echo "Selesai!";
