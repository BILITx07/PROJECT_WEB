<?php
function searchImage($query) {
    $url = "https://html.duckduckgo.com/html/?q=" . urlencode($query . " produk outdoor");
    $opts = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36\r\n"
        ]
    ];
    $context = stream_context_create($opts);
    $html = @file_get_contents($url, false, $context);
    
    if ($html) {
        // Find the first image link
        if (preg_match('/<img[^>]+src="([^">]+)"/', $html, $matches)) {
            $imgUrl = $matches[1];
            if (strpos($imgUrl, '//') === 0) {
                $imgUrl = 'https:' . $imgUrl;
            }
            return $imgUrl;
        }
    }
    return null;
}

$url = searchImage('koper 20 inci cokelat');
echo "Image URL: " . $url . "\n";
