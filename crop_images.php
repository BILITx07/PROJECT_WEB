<?php
$names1 = ['tenda_5_6.jpg', 'tenda_4_5.jpg', 'tenda_3_4.jpg', 'tenda_2_3.jpg', 'tenda_1_2.jpg', 'tas_60l.jpg', 'tas_45l.jpg', 'tas_25l.jpg', 'kompor_kecil.jpg', 'kompor_besar.jpg'];
function processGrid($imgPath, $outputNames) {
    if (!file_exists($imgPath)) {
        echo "File not found: $imgPath\n";
        return;
    }
    $img = @imagecreatefromjpeg($imgPath);
    if (!$img) {
        echo "Could not read image: $imgPath\n";
        return;
    }
    $w = imagesx($img);
    $h = imagesy($img);
    $cw = $w / 2;
    $ch = $h / 5;
    $idx = 0;
    for ($row = 0; $row < 5; $row++) {
        for ($col = 0; $col < 2; $col++) {
            if ($idx >= count($outputNames)) break;
            $left = $col * $cw;
            $top = $row * $ch;
            $cropped = imagecrop($img, ['x' => $left, 'y' => $top, 'width' => $cw, 'height' => $ch]);
            if ($cropped !== FALSE) {
                imagejpeg($cropped, 'public/storage/items/' . $outputNames[$idx]);
                imagedestroy($cropped);
                echo "Saved public/storage/items/" . $outputNames[$idx] . "\n";
            } else {
                echo "Failed to crop " . $outputNames[$idx] . "\n";
            }
            $idx++;
        }
    }
    imagedestroy($img);
}
@mkdir('public/storage/items', 0777, true);
echo "Processing Image 1...\n";
processGrid('C:\Users\user\Downloads\WhatsApp Image 2026-06-24 at 12.47.28.jpeg', $names1);

echo "Processing Image 2...\n";
$names2 = ['sleeping_bag.jpg', 'sepatu_gunung.jpg', 'jaket_gunung.jpg', 'hammock.jpg', 'gas_portable.jpg', 'jerigen.jpg', 'kursi_lipat.jpg', 'tracking_pole.jpg', 'meja_lipat.jpg', 'hydropack.jpg'];
processGrid('C:\Users\user\Downloads\WhatsApp Image 2026-06-24 at 12.47.42.jpeg', $names2);

echo "Processing Image 3...\n";
$img3Path = 'C:\Users\user\Downloads\WhatsApp Image 2026-06-24 at 12.47.51.jpeg';
if (file_exists($img3Path)) { 
    copy($img3Path, 'public/storage/items/kacamata.jpg'); 
    echo "Saved public/storage/items/kacamata.jpg\n";
} else {
    echo "File not found: $img3Path\n";
}
echo "Selesai!\n";
