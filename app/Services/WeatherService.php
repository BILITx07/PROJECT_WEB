<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    /**
     * Get 3-day forecast for all registered destinations in Kalimantan.
     */
    public function getDestinationsForecast()
    {
        $cacheKey = 'weather_destinations_forecast';
        
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $data = $this->fetchFromOpenMeteo();
        
        // Hanya simpan ke cache jika data berhasil didapatkan (tidak kosong)
        if (!empty($data)) {
            Cache::put($cacheKey, $data, 600); // 10 menit
        }

        return $data;
    }

    private function fetchFromOpenMeteo()
    {
        $destinations = [
            [
                'name' => 'Bukit Raya',
                'location' => 'Kalimantan Tengah',
                'lat' => -0.6633,
                'lon' => 112.7844,
                'image' => asset('images/destinations/bukit_raya.png')
            ],
            [
                'name' => 'Bukit Kelam',
                'location' => 'Sintang, Kalbar',
                'lat' => 0.0825,
                'lon' => 111.6425,
                'image' => asset('images/destinations/bukit_kelam.png')
            ],
            [
                'name' => 'Gunung Bawang',
                'location' => 'Bengkayang, Kalbar',
                'lat' => 0.8920,
                'lon' => 109.3780,
                'image' => asset('images/destinations/gunung_bawang.png')
            ],
            [
                'name' => 'Bukit Jamur',
                'location' => 'Bengkayang, Kalbar',
                'lat' => 0.8160,
                'lon' => 109.2150,
                'image' => asset('images/destinations/bukit_jamur.png')
            ],
            [
                'name' => 'Riam Merasap',
                'location' => 'Bengkayang, Kalbar',
                'lat' => 1.0540,
                'lon' => 109.7040,
                'image' => asset('images/destinations/riam_merasap.png')
            ],
            [
                'name' => 'Riam Dait',
                'location' => 'Landak, Kalbar',
                'lat' => 0.4430,
                'lon' => 109.9570,
                'image' => asset('images/destinations/riam_dait.png')
            ],
        ];

        $lats = implode(',', array_column($destinations, 'lat'));
        $lons = implode(',', array_column($destinations, 'lon'));

        try {
            $response = Http::timeout(10)->get('https://api.open-meteo.com/v1/forecast', [
                'latitude' => $lats,
                'longitude' => $lons,
                'daily' => 'weather_code,temperature_2m_max,temperature_2m_min',
                'timezone' => 'Asia/Jakarta',
                'forecast_days' => 3
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Open-Meteo returns array of locations if multiple coordinates are passed
                $results = [];
                // If only 1 coord passed it doesn't return array, but we passed 6 so it will be an array
                $locationsData = isset($data[0]) ? $data : [$data];

                foreach ($destinations as $index => $dest) {
                    $weatherData = $locationsData[$index]['daily'] ?? null;
                    if (!$weatherData) continue;

                    $forecasts = [];
                    // We expect 3 days
                    for ($i = 0; $i < count($weatherData['time']); $i++) {
                        $wmoCode = $weatherData['weather_code'][$i];
                        $maxTemp = round($weatherData['temperature_2m_max'][$i]);
                        $minTemp = round($weatherData['temperature_2m_min'][$i]);
                        $avgTemp = round(($maxTemp + $minTemp) / 2);
                        
                        $mapped = $this->mapWmoCode($wmoCode);

                        // Format date nicely
                        $date = \Carbon\Carbon::parse($weatherData['time'][$i])->locale('id');
                        $dayLabel = '';
                        if ($i === 0) $dayLabel = 'Hari Ini';
                        elseif ($i === 1) $dayLabel = 'Besok';
                        else $dayLabel = $date->translatedFormat('l'); // e.g., "Senin"

                        $forecasts[] = [
                            'date_raw' => $weatherData['time'][$i],
                            'date_label' => $dayLabel,
                            'date_short' => $date->format('d M'),
                            'temp' => $avgTemp,
                            'status_text' => $mapped['text'],
                            'status_badge' => $mapped['badge'],
                            'status_color' => $mapped['color'],
                            'icon' => $mapped['icon'],
                        ];
                    }

                    $mainStatus = $forecasts[0] ?? null;

                    $results[] = [
                        'name' => $dest['name'],
                        'location' => $dest['location'],
                        'lat' => $dest['lat'],
                        'lon' => $dest['lon'],
                        'image' => $dest['image'],
                        'main_status' => $mainStatus,
                        'forecasts' => $forecasts
                    ];
                }

                return $results;
            }
            
            Log::error('Open-Meteo API Error: ' . $response->body());
            return [];

        } catch (\Exception $e) {
            Log::error('Open-Meteo Exception: ' . $e->getMessage());
            return [];
        }
    }

    private function mapWmoCode($code)
    {
        if ($code == 0) {
            return ['text' => 'Cerah', 'badge' => 'Sangat Aman', 'color' => '#10b981', 'icon' => 'fa-sun']; // Green
        } elseif (in_array($code, [1, 2, 3])) {
            return ['text' => 'Berawan', 'badge' => 'Aman', 'color' => '#10b981', 'icon' => 'fa-cloud-sun'];
        } elseif (in_array($code, [45, 48])) {
            return ['text' => 'Berkabut', 'badge' => 'Hati-hati', 'color' => '#6b7280', 'icon' => 'fa-smog'];
        } elseif (in_array($code, [51, 53, 55, 56, 57])) {
            return ['text' => 'Gerimis', 'badge' => 'Hati-hati', 'color' => '#f59e0b', 'icon' => 'fa-cloud-rain'];
        } elseif (in_array($code, [61, 63, 65, 66, 67])) {
            return ['text' => 'Hujan', 'badge' => 'Persiapan Ekstra', 'color' => '#f59e0b', 'icon' => 'fa-cloud-showers-heavy'];
        } elseif (in_array($code, [80, 81, 82])) {
            return ['text' => 'Hujan Lebat', 'badge' => 'Waspada Badai', 'color' => '#ef4444', 'icon' => 'fa-cloud-showers-heavy'];
        } elseif (in_array($code, [95, 96, 99])) {
            return ['text' => 'Badai Petir', 'badge' => 'Tunda Perjalanan', 'color' => '#ef4444', 'icon' => 'fa-bolt'];
        } else {
            return ['text' => 'Cuaca Buruk', 'badge' => 'Berbahaya', 'color' => '#ef4444', 'icon' => 'fa-cloud'];
        }
    }
}
