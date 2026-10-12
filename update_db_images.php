<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Item;

foreach(Item::all() as $item) {
    if (str_starts_with($item->image, 'images/items/')) {
        $item->image = str_replace('images/items/', 'items/', $item->image);
        $item->save();
    }
}
echo "DB Updated!";
