<?php
$url = 'https://api.open-meteo.com/v1/forecast?latitude=0&longitude=0&daily=weathercode,temperature_2m_max,temperature_2m_min&start_date=2026-06-30&end_date=2026-06-30&timezone=Asia%2FJakarta';
$res = file_get_contents($url);
print_r(json_decode($res, true)['daily']);
