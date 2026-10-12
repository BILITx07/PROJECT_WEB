<?php
$lats = '-0.6633,0.0825,0.8920,0.8160,1.0540,0.4430';
$lons = '112.7844,111.6425,109.3780,109.2150,109.7040,109.9570';
$url = 'https://api.open-meteo.com/v1/forecast?latitude=' . $lats . '&longitude=' . $lons . '&daily=weather_code,temperature_2m_max,temperature_2m_min&timezone=Asia/Jakarta&forecast_days=3';

$res = file_get_contents($url);
$data = json_decode($res, true);

// Index 1 is Bukit Kelam
print_r($data[1]['daily']);
