@extends('layouts.user')

@section('title', 'Jelajah Barang - CampRent')

@section('content')
@section('hero')
<!-- Hero Section with Search -->
<div class="hero-section">
    <div class="hero-content" style="max-width: 1200px; margin: 0 auto; width: 100%; padding-top: 2rem;">
        <span data-aos="fade-down" data-aos-delay="100" class="hero-subtitle" style="color: #4ade80; font-weight: 600; font-size: 1.2rem; letter-spacing: 0.5px; display: block; margin-bottom: 0.5rem; text-shadow: 0 1px 2px rgba(0,0,0,0.5);">
            Siap Menjelajah, Tanpa Ribet.
        </span>
        <h1 data-aos="fade-right" data-aos-delay="200" class="hero-title-main" style="color: #ffffff; font-size: 3.5rem; font-weight: 800; line-height: 1.1; margin-bottom: 2rem; max-width: 800px; text-shadow: 0 2px 10px rgba(0,0,0,0.5); text-align: left;">
            Sewa Gear Outdoor<br>Kini Lebih Mudah!
        </h1>
        
        <div class="hero-checklist" style="display: flex; flex-wrap: wrap; gap: 1.5rem; margin-bottom: 3.5rem;">
            <div data-aos="fade-up" data-aos-delay="300" class="check-item" style="display: flex; align-items: center; gap: 0.5rem; font-weight: 600; text-shadow: 0 1px 3px rgba(0,0,0,0.5); font-size: 1.05rem;">
                <i class="fa-solid fa-circle-check" style="color: #4ade80; font-size: 1.25rem;"></i>
                <span>Stok Real-Time & Lengkap</span>
            </div>
            <div data-aos="fade-up" data-aos-delay="400" class="check-item" style="display: flex; align-items: center; gap: 0.5rem; font-weight: 600; text-shadow: 0 1px 3px rgba(0,0,0,0.5); font-size: 1.05rem;">
                <i class="fa-solid fa-circle-check" style="color: #4ade80; font-size: 1.25rem;"></i>
                <span>Praktis & Cepat</span>
            </div>
            <div data-aos="fade-up" data-aos-delay="500" class="check-item" style="display: flex; align-items: center; gap: 0.5rem; font-weight: 600; text-shadow: 0 1px 3px rgba(0,0,0,0.5); font-size: 1.05rem;">
                <i class="fa-solid fa-circle-check" style="color: #4ade80; font-size: 1.25rem;"></i>
                <span>Layanan Khusus PONTIANAK</span>
            </div>
        </div>

    </div>
</div>
@endsection

<!-- Live Weather Widget -->
<style>
    .weather-card {
        border-radius: 24px;
        padding: 0;
        border: none;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        color: white;
        flex: 0 0 280px; 
        height: 380px;
        scroll-snap-align: start;
        position: relative;
        overflow: hidden;
        background-size: cover;
        background-position: center;
    }
    
    .weather-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.85) 100%);
        z-index: 1;
        transition: opacity 0.3s ease;
    }

    .weather-card-content {
        position: relative;
        z-index: 2;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        height: 100%;
        justify-content: space-between;
    }
    
    .weather-scroll-container {
        display: flex;
        overflow-x: auto;
        gap: 1.5rem;
        padding-bottom: 1rem;
        scroll-snap-type: x mandatory;
        scrollbar-width: thin;
        scrollbar-color: #d1d5db transparent;
    }
    
    .weather-scroll-container::-webkit-scrollbar {
        height: 6px;
    }
    .weather-scroll-container::-webkit-scrollbar-track {
        background: transparent;
    }
    .weather-scroll-container::-webkit-scrollbar-thumb {
        background-color: #d1d5db;
        border-radius: 20px;
    }
</style>
<div data-aos="fade-up" class="weather-widget-section" style="max-width: 1200px; margin: -100px auto 3rem auto; padding: 2rem; background: #ffffff; border-radius: 24px; box-shadow: 0 15px 40px rgba(0,0,0,0.15); position: relative; z-index: 10;">
    <!-- Long-term Weather Search Box -->
    <div style="margin-bottom: 3rem; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 20px; padding: 2rem;">
        <div style="margin-bottom: 1.5rem;">
            <h3 style="font-family: 'Urbanist', sans-serif; font-size: 1.5rem; font-weight: 800; color: #111827; margin: 0 0 0.5rem 0;">Cek Cuaca Jangka Panjang</h3>
            <p style="color: #6b7280; font-size: 0.95rem; margin: 0;">Rencanakan perjalanan Anda jauh hari dengan memeriksa prakiraan cuaca untuk tanggal spesifik.</p>
        </div>
        
        <form onsubmit="checkLongTermWeather(event)" style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: flex-end;">
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #374151; margin-bottom: 0.5rem;">Pilih Destinasi</label>
                <select id="long_term_dest" style="width: 100%; padding: 0.75rem 1rem; border-radius: 12px; border: 1px solid #d1d5db; background: white; font-family: inherit; font-size: 1rem; color: #111827; outline: none; transition: border-color 0.2s;" required>
                    <option value="" disabled selected>Pilih Gunung / Riam...</option>
                    @if(isset($weatherForecasts))
                        @foreach($weatherForecasts as $dest)
                            <option value="{{ $dest['name'] }}" data-lat="{{ $dest['lat'] ?? 0 }}" data-lon="{{ $dest['lon'] ?? 0 }}" data-image="{{ $dest['image'] }}">{{ $dest['name'] }} ({{ $dest['location'] }})</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #374151; margin-bottom: 0.5rem;">Pilih Tanggal</label>
                <input type="date" id="long_term_date" style="width: 100%; padding: 0.75rem 1rem; border-radius: 12px; border: 1px solid #d1d5db; background: white; font-family: inherit; font-size: 1rem; color: #111827; outline: none; transition: border-color 0.2s;" required>
            </div>
            <button type="submit" style="padding: 0.75rem 2rem; background: #10b981; color: white; border: none; border-radius: 12px; font-weight: 700; font-size: 1rem; cursor: pointer; transition: background 0.3s; font-family: 'Urbanist', sans-serif;">
                <i class="fa-solid fa-magnifying-glass" style="margin-right: 0.5rem;"></i> Cek Cuaca
            </button>
        </form>
        
        <!-- Search Result Box -->
        <div id="long_term_result" style="display: none; margin-top: 2rem; border-top: 1px solid #e5e7eb; padding-top: 2rem;">
            <div id="long_term_result_content"></div>
        </div>
    </div>

    <div style="margin-bottom: 2rem;">
        <h2 data-aos="fade-right" style="font-family: 'Urbanist', sans-serif; font-size: 2.25rem; font-weight: 800; color: #111827; margin-bottom: 0.25rem; display: flex; align-items: center; gap: 0.75rem;">
            Info Cuaca Destinasi <i class="fa-solid fa-cloud-sun" style="color: #f59e0b;"></i>
        </h2>
        <p style="color: #6b7280; font-size: 1rem; margin: 0;">Pantau cuaca hari ini di destinasi favorit Anda secara real-time.</p>
    </div>

    <div class="weather-scroll-container">
        @if(isset($weatherForecasts) && count($weatherForecasts) > 0)
            @foreach($weatherForecasts as $dest)
                <div data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}" class="weather-card" style="background-image: url('{{ $dest['image'] }}'); height: 280px;">
                    <div class="weather-card-content">
                        <!-- Main top part: Destination Info -->
                        <div>
                            @if($dest['main_status'])
                            <div style="margin-bottom: 0.75rem;">
                                <span style="background: {{ $dest['main_status']['status_color'] }}; color: #ffffff; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 4px 10px {{ $dest['main_status']['status_color'] }}4D;">
                                    {{ $dest['main_status']['status_badge'] }}
                                </span>
                            </div>
                            @endif
                            <h4 style="margin: 0 0 0.25rem 0; font-family: 'Urbanist', sans-serif; font-size: 1.6rem; font-weight: 800; color: #ffffff; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">{{ $dest['name'] }}</h4>
                            <p style="margin: 0; font-size: 0.95rem; color: #e5e7eb; font-weight: 500; display: flex; align-items: center; gap: 0.4rem;">
                                <i class="fa-solid fa-location-dot" style="color: #4ade80;"></i> {{ $dest['location'] }}
                            </p>
                        </div>
                        
                        <!-- Current Weather info at bottom -->
                        @if($dest['main_status'])
                        <div style="margin-top: auto; display: flex; align-items: flex-end; justify-content: space-between;">
                            <div style="display: flex; flex-direction: column;">
                                <span style="font-size: 0.75rem; color: #d1d5db; font-weight: 600; text-transform: uppercase;">Hari Ini</span>
                                <span style="font-size: 0.95rem; color: #ffffff; font-weight: 600;">{{ $dest['main_status']['status_text'] }}</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.5rem; background: rgba(0,0,0,0.3); backdrop-filter: blur(8px); padding: 0.5rem 1rem; border-radius: 100px; border: 1px solid rgba(255,255,255,0.2);">
                                <i class="fa-solid {{ $dest['main_status']['icon'] }}" style="font-size: 1.25rem; color: {{ $dest['main_status']['status_color'] }};"></i>
                                <span style="font-size: 1.25rem; font-weight: 800; color: #ffffff;">{{ $dest['main_status']['temp'] }}°C</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div style="padding: 2rem; text-align: center; color: #6b7280; width: 100%;">
                <i class="fa-solid fa-cloud-bolt" style="font-size: 2rem; margin-bottom: 1rem; color: #d1d5db;"></i>
                <p>Data cuaca sedang tidak dapat diakses saat ini. Silakan coba beberapa saat lagi.</p>
            </div>
        @endif
    </div>


</div>

<script>
    async function checkLongTermWeather(event) {
        event.preventDefault();
        
        const destSelect = document.getElementById('long_term_dest');
        const dateInput = document.getElementById('long_term_date');
        const resultDiv = document.getElementById('long_term_result');
        const resultContent = document.getElementById('long_term_result_content');
        
        const selectedOption = destSelect.options[destSelect.selectedIndex];
        const destName = selectedOption.value;
        const destLocation = selectedOption.text.split(' (')[1].replace(')', ''); // Extract location text
        const lat = selectedOption.getAttribute('data-lat');
        const lon = selectedOption.getAttribute('data-lon');
        const image = selectedOption.getAttribute('data-image');
        const selectedDate = dateInput.value;
        
        if (!destName || !selectedDate || !lat) return;

        resultDiv.style.display = 'block';
        resultContent.innerHTML = '<div style="text-align:center; padding: 2rem;"><i class="fa-solid fa-spinner fa-spin" style="font-size: 2rem; color: #10b981; margin-bottom: 1rem;"></i><p>Menghubungkan ke satelit cuaca...</p></div>';

        // Calculate days difference
        const targetDateObj = new Date(selectedDate);
        targetDateObj.setHours(0,0,0,0);
        const todayObj = new Date();
        todayObj.setHours(0,0,0,0);
        const diffTime = targetDateObj - todayObj;
        const diffDays = Math.round(diffTime / (1000 * 60 * 60 * 24));

        try {
            let apiUrl = '';
            let isHistorical = false;
            
            if (diffDays >= 0 && diffDays <= 15) {
                // Use Forecast API (up to 16 days including today)
                apiUrl = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&daily=weathercode,temperature_2m_max,temperature_2m_min&start_date=${selectedDate}&end_date=${selectedDate}&timezone=Asia%2FJakarta`;
            } else if (diffDays > 15) {
                // Use Historical API from exactly 1 year ago as an estimate
                isHistorical = true;
                const pastYear = targetDateObj.getFullYear() - 1;
                const pastDate = `${pastYear}-${String(targetDateObj.getMonth()+1).padStart(2,'0')}-${String(targetDateObj.getDate()).padStart(2,'0')}`;
                apiUrl = `https://archive-api.open-meteo.com/v1/archive?latitude=${lat}&longitude=${lon}&start_date=${pastDate}&end_date=${pastDate}&daily=weathercode,temperature_2m_max,temperature_2m_min&timezone=Asia%2FJakarta`;
            } else {
                 resultContent.innerHTML = '<div style="color: #ef4444; background: #fee2e2; padding: 1rem; border-radius: 12px;"><i class="fa-solid fa-triangle-exclamation"></i> Silakan pilih tanggal hari ini atau di masa depan.</div>';
                 return;
            }

            const response = await fetch(apiUrl, { cache: 'no-store' });
            const data = await response.json();

            if (data.daily && data.daily.time && data.daily.time.length > 0) {
                const code = data.daily.weathercode[0];
                const tempMax = Math.round(data.daily.temperature_2m_max[0]);
                const tempMin = Math.round(data.daily.temperature_2m_min[0]);
                
                // Complete WMO translation matching PHP backend
                let icon = 'fa-cloud';
                let text = 'Cuaca Buruk';
                let color = '#ef4444'; // default red
                
                if (code == 0) { icon = 'fa-sun'; text = 'Cerah'; color = '#10b981'; }
                else if (code >= 1 && code <= 3) { icon = 'fa-cloud-sun'; text = 'Berawan'; color = '#10b981'; }
                else if (code == 45 || code == 48) { icon = 'fa-smog'; text = 'Berkabut'; color = '#6b7280'; }
                else if (code >= 51 && code <= 57) { icon = 'fa-cloud-rain'; text = 'Gerimis'; color = '#f59e0b'; }
                else if (code >= 61 && code <= 67) { icon = 'fa-cloud-showers-heavy'; text = 'Hujan'; color = '#f59e0b'; }
                else if (code >= 80 && code <= 82) { icon = 'fa-cloud-showers-heavy'; text = 'Hujan Lebat'; color = '#ef4444'; }
                else if (code >= 95) { icon = 'fa-bolt'; text = 'Badai Petir'; color = '#ef4444'; }
                
                let html = `
                <div style="max-width: 400px; margin: 0 auto;">
                    <div class="weather-card" style="background-image: url('${image}'); height: 280px; position: relative;">
                        <div class="weather-card-content">
                            <!-- Main top part: Destination Info -->
                            <div>
                                <div style="margin-bottom: 0.75rem;">
                                    <span style="background: ${color}; color: #ffffff; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 4px 10px ${color}4D;">
                                        Prakiraan Khusus
                                    </span>
                                </div>
                                <h4 style="margin: 0 0 0.25rem 0; font-family: 'Urbanist', sans-serif; font-size: 1.6rem; font-weight: 800; color: #ffffff; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">${destName}</h4>
                                <p style="margin: 0; font-size: 0.95rem; color: #e5e7eb; font-weight: 500; display: flex; align-items: center; gap: 0.4rem;">
                                    <i class="fa-solid fa-location-dot" style="color: #4ade80;"></i> ${destLocation}
                                </p>
                            </div>
                            
                            <!-- Current Weather info at bottom -->
                            <div style="margin-top: auto; display: flex; align-items: flex-end; justify-content: space-between;">
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-size: 0.75rem; color: #d1d5db; font-weight: 600; text-transform: uppercase;"><i class="fa-regular fa-calendar" style="margin-right: 0.3rem;"></i>${selectedDate}</span>
                                    <span style="font-size: 0.95rem; color: #ffffff; font-weight: 600;">${text}</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 0.5rem; background: rgba(0,0,0,0.3); backdrop-filter: blur(8px); padding: 0.5rem 1rem; border-radius: 100px; border: 1px solid rgba(255,255,255,0.2);">
                                    <i class="fa-solid ${icon}" style="font-size: 1.25rem; color: ${color};"></i>
                                    <span style="font-size: 1.25rem; font-weight: 800; color: #ffffff;">${tempMax}°C</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
                
                if (isHistorical) {
                    html += `<div style="margin-top: 1rem; padding: 1rem; background: #fffbeb; border: 1px solid #fde68a; border-radius: 12px; display: flex; gap: 0.75rem;">
                        <i class="fa-solid fa-circle-info" style="color: #f59e0b; margin-top: 0.2rem;"></i>
                        <p style="margin: 0; font-size: 0.85rem; color: #92400e; line-height: 1.5;">Karena tanggal yang Anda pilih melebihi 16 hari ke depan, prakiraan cuaca satelit tidak tersedia. Sistem kami secara pintar menampilkan <b>Data Iklim Historis (tahun sebelumnya)</b> pada tanggal dan lokasi yang persis sama sebagai referensi cuaca rata-rata Anda.</p>
                    </div>`;
                }
                
                resultContent.innerHTML = html;
            } else {
                resultContent.innerHTML = '<div style="color: #ef4444; background: #fee2e2; padding: 1rem; border-radius: 12px;"><i class="fa-solid fa-triangle-exclamation"></i> Gagal mengambil data cuaca untuk tanggal tersebut dari satelit.</div>';
            }

        } catch (error) {
            resultContent.innerHTML = '<div style="color: #ef4444; background: #fee2e2; padding: 1rem; border-radius: 12px;"><i class="fa-solid fa-triangle-exclamation"></i> Terjadi kesalahan koneksi ke server cuaca global Open-Meteo.</div>';
        }
    }
</script>

<!-- Pilihan Brand Section -->
<style>
    @keyframes scrollBrands {
        0% { transform: translateX(0); }
        100% { transform: translateX(calc(-50% - 0.75rem)); }
    }
    @-webkit-keyframes scrollBrands {
        0% { -webkit-transform: translateX(0); }
        100% { -webkit-transform: translateX(calc(-50% - 0.75rem)); }
    }
    .brand-slider-track {
        display: flex; 
        gap: 1.5rem; 
        width: max-content; 
        animation: scrollBrands 30s linear infinite;
        -webkit-animation: scrollBrands 30s linear infinite;
        will-change: transform;
    }
    .brand-slider-track:hover {
        animation-play-state: paused !important;
        -webkit-animation-play-state: paused !important;
    }
</style>
<div class="brands-section" style="max-width: 1200px; margin: 4rem auto 1rem auto; padding: 0 1.5rem; overflow: hidden;">
    <div data-aos="fade-up" style="margin-bottom: 2rem;">
        <h2 style="font-family: 'Urbanist', sans-serif; font-size: 2.25rem; font-weight: 800; color: #111827; margin-bottom: 0.25rem;">Pilihan Brand</h2>
        <p style="color: #6b7280; font-size: 1rem; margin: 0;">Dipilih dari merek terbaik untuk pengalaman terbaik.</p>
    </div>
    
    <div data-aos="zoom-in" data-aos-delay="200" class="brand-slider-container" style="position: relative; width: 100%; overflow: hidden; padding: 1rem 0;">
        <!-- Gradient masks for smooth edges -->
        <div style="position: absolute; top: 0; bottom: 0; left: 0; width: 60px; background: linear-gradient(to right, #f8fafc, transparent); z-index: 2;"></div>
        <div style="position: absolute; top: 0; bottom: 0; right: 0; width: 60px; background: linear-gradient(to left, #f8fafc, transparent); z-index: 2;"></div>
        
        <div class="brand-slider-track">
            <!-- First set of logos -->
            @php
                $brands = [
                    'brand_r9MEiBEAajJYitlmOJrK.jpg',
                    'brand_6F0I3chKU6Gw6BpzsbEH.jpg',
                    'brand_ypI3GUgHKlUTYvoJaLvw.jpg',
                    'brand_jZ8EpmrI61g8O7AeFX90.jpg',
                    'brand_HxkeeT11i4EPsUwIVDaJ.jpg',
                    'brand_nUaUjco40sCZQ8ncEcxm.jpg',
                    'brand_EBFw4gAuLJzpfrWn8uch.jpg',
                    'brand_eMp11fyNX6EkaIPJWXre.jpg',
                    'brand_UiH8c05Htb1tJ1APdoU0.jpg',
                    'brand_68Dtff8Pk8pPC3ChVKb6.jpg',
                    'brand_AefumENqKe7gfwPr72ma.jpg',
                    'brand_hJ5YFPCUIAGXoKBlU66k.jpg',
                ];
            @endphp
            @foreach($brands as $brand)
                <div class="brand-card" style="background: white; border-radius: 12px; border: 1px solid #eaeaea; padding: 1.5rem; min-width: 180px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                    <img src="https://www.forestaadventure.com/brand_attachment/{{ $brand }}" alt="Brand Logo" style="max-height: 50px; max-width: 100%; object-fit: contain;">
                </div>
            @endforeach
            <!-- Duplicate set for infinite scroll effect -->
            @foreach($brands as $brand)
                <div class="brand-card" style="background: white; border-radius: 12px; border: 1px solid #eaeaea; padding: 1.5rem; min-width: 180px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                    <img src="https://www.forestaadventure.com/brand_attachment/{{ $brand }}" alt="Brand Logo" style="max-height: 50px; max-width: 100%; object-fit: contain;">
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Section Title -->
<div data-aos="fade-up" class="section-title-wrapper" style="max-width: 1200px; margin: 4rem auto 2rem auto; padding: 0 1.5rem; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h2 style="font-family: 'Outfit', sans-serif; font-size: 2.25rem; font-weight: 800; color: #111827; margin-bottom: 0.25rem;">Pilihan Terbaik Minggu Ini!</h2>
        <p style="color: #6b7280; font-size: 1rem; margin: 0;">Gear Pilihan Pendaki, Siap Temani Petualanganmu.</p>
    </div>
    <a href="{{ route('user.products') }}" style="background-color: #4ade80; color: #111827; padding: 0.6rem 1.25rem; border-radius: 8px; font-weight: 700; text-decoration: none; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 0.5rem; transition: background 0.3s; box-shadow: 0 4px 10px rgba(74,222,128,0.2);">
        Lihat Lainnya <i class="fa-solid fa-arrow-right"></i>
    </a>
</div>

<!-- Product Listings -->
<div class="product-grid">
    @forelse ($items as $item)
        <div data-aos="fade-up" data-aos-delay="{{ ($loop->iteration % 4) * 100 }}" class="product-card" style="position: relative;">
            <!-- Wishlist Heart Icon -->
            @php
                $isWishlisted = isset($wishlistIds) && in_array($item->id, $wishlistIds);
            @endphp
            <button type="button" class="wishlist-toggle-btn" data-id="{{ $item->id }}" 
                    style="position: absolute; top: 12px; right: 12px; width: 36px; height: 36px; border-radius: 50%; background: white; border: none; box-shadow: 0 4px 10px rgba(0,0,0,0.1); cursor: pointer; display: flex; align-items: center; justify-content: center; z-index: 10; transition: transform 0.2s ease;">
                <i class="{{ $isWishlisted ? 'fa-solid' : 'fa-regular' }} fa-heart" 
                   style="color: {{ $isWishlisted ? '#ff4757' : '#95a5a6' }}; font-size: 18px; transition: color 0.2s ease;"></i>
            </button>
            
            <div class="product-image-container">
                @if ($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="product-image">
                @else
                    <div class="product-image-placeholder">
                        <i class="fa-solid fa-tents fa-3x" style="color: var(--light-gray); margin-bottom: 0.5rem;"></i>
                        <span>No Image Available</span>
                    </div>
                @endif
            </div>
            <div class="product-details">
                <div style="margin-bottom: 0.25rem;">
                    @if ($item->stock > 0)
                        <span class="product-stock status-instock">Stok: {{ $item->stock }}</span>
                    @else
                        <span class="product-stock status-out">Stok Habis</span>
                    @endif
                </div>
                
                <h3 class="product-title" style="margin-top: 0.25rem;">{{ $item->name }}</h3>
                <p class="product-subtitle" style="margin-bottom: 0.25rem;">{{ $item->category }}</p>
                
                @if ($item->description)
                <p class="product-desc" style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.5rem; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; white-space: pre-line;">
                    {{ $item->description }}
                </p>
                @endif
                
                <!-- Rating Row -->
                <div class="product-rating">
                    <i class="fa-solid fa-star"></i>
                    <span>{{ number_format(4.5 + (($item->id * 7) % 5) / 10, 1) }} ({{ 50 + (($item->id * 13) % 150) }})</span>
                </div>
                
                <div class="product-meta">
                    <div class="product-price">
                        <span class="price-label">Rp {{ number_format($item->price_per_day, 0, ',', '.') }}</span>
                        <span class="price-unit">/ hari</span>
                    </div>
                </div>
                <div class="product-actions">
                    <form action="{{ route('user.cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <input type="hidden" name="redirect" value="cart">
                        <button type="submit" class="btn-sewa-sekarang" {{ $item->stock <= 0 ? 'disabled' : '' }}>
                            {{ $item->stock <= 0 ? 'Stok Habis' : 'Sewa Sekarang' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="empty-state" style="grid-column: 1 / -1;">
            <i class="fa-regular fa-folder-open fa-3x" style="color: var(--text-muted); margin-bottom: 1rem; display:block;"></i>
            <h3>Barang Tidak Ditemukan</h3>
            <p>Maaf, barang yang Anda cari tidak tersedia dalam kategori ini.</p>
        </div>
    @endforelse
</div>

<!-- Kenapa Memilih CAMPrent Section -->
<div class="why-us-section">
    <h3 data-aos="fade-up" class="why-us-title">Kenapa Memilih CAMPrent?</h3>
    <div class="why-us-grid">
        <div data-aos="fade-up" data-aos-delay="100" class="why-us-card">
            <div class="why-us-icon-container">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div class="why-us-info">
                <h4 class="why-us-card-title">Barang Berkualitas</h4>
                <p class="why-us-card-desc">Semua peralatan kami terawat dan terbaik</p>
            </div>
        </div>
        <div data-aos="fade-up" data-aos-delay="200" class="why-us-card">
            <div class="why-us-icon-container">
                <i class="fa-solid fa-tags"></i>
            </div>
            <div class="why-us-info">
                <h4 class="why-us-card-title">Harga Terjangkau</h4>
                <p class="why-us-card-desc">Harga sewa bersaing dan transparan</p>
            </div>
        </div>
        <div data-aos="fade-up" data-aos-delay="300" class="why-us-card">
            <div class="why-us-icon-container">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div class="why-us-info">
                <h4 class="why-us-card-title">Booking Mudah</h4>
                <p class="why-us-card-desc">Proses pemesanan cepat dan praktis</p>
            </div>
        </div>
        <div data-aos="fade-up" data-aos-delay="400" class="why-us-card">
            <div class="why-us-icon-container">
                <i class="fa-solid fa-compass"></i>
            </div>
            <div class="why-us-info">
                <h4 class="why-us-card-title">Siap Petualangan</h4>
                <p class="why-us-card-desc">Perlengkapan siap menemani setiap petualanganmu.</p>
            </div>
        </div>
    </div>
</div>

<!-- Terms & Conditions Popup (Modal) -->
@if (auth()->check() && !auth()->user()->terms_accepted)
<div class="popup-overlay" id="terms-modal">
    <div class="popup-card">
        <button class="popup-close-btn" onclick="closeTermsPopup()">&times;</button>
        <div class="popup-header">
            <h3 class="popup-title">Syarat & Ketentuan</h3>
        </div>
        <div class="popup-content-box">
            <p><strong>1. Jaminan Identitas</strong><br>Penyewa wajib menggunakan Kartu Identitas (ID Card) asli dan masih berlaku sesuai dengan nama penyewa sebagai jaminan. ID Card yang dijaminkan bisa berupa KTP/SIM/KK. Khusus untuk pelajar wajib menjaminkan Kartu Pelajar dan KTP asli milik orang tua penyewa.</p>
            <p><strong>2. Jam Operasional</strong><br>Penyewaan kami buka 24 jam (Layanan Fast Respon). Disarankan untuk melakukan perjanjian terlebih dahulu sebelum melakukan pengambilan.</p>
            <p><strong>3. Pembayaran</strong><br>Pembayaran sewa wajib lunas pada waktu pengambilan barang di toko.</p>
            <p><strong>4. Perhitungan Biaya</strong><br>Biaya sewa dihitung per 24 jam dimulai dari tanggal dan jam pengambilan barang.</p>
        </div>
        <button class="btn-popup-close" onclick="closeTermsPopup()">tutup</button>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
    function closeTermsPopup() {
        fetch('{{ route("user.accept_terms") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('terms-modal').style.display = 'none';
            } else {
                window.location.reload();
            }
        })
        .catch(err => {
            console.error(err);
            // fallback
            document.getElementById('terms-modal').style.display = 'none';
        });
    }

    // Adjust End Date Min based on Start Date Selection
    const startDateElement = document.getElementById('start_date');
    if (startDateElement) {
        startDateElement.addEventListener('change', function() {
            const startDateVal = this.value;
            const endDateInput = document.getElementById('end_date');
            
            // End date must be at least start date + 1 day
            const parts = startDateVal.split('-');
            const date = new Date(parts[0], parts[1] - 1, parts[2]);
            date.setDate(date.getDate() + 1);
            
            const yyyy = date.getFullYear();
            const mm = String(date.getMonth() + 1).padStart(2, '0');
            const dd = String(date.getDate()).padStart(2, '0');
            
            if (endDateInput) {
                endDateInput.min = `${yyyy}-${mm}-${dd}`;
                if (endDateInput.value <= startDateVal) {
                    endDateInput.value = `${yyyy}-${mm}-${dd}`;
                }
            }
        });
    }

    // Wishlist Toggle Logic
    const wishlistBtns = document.querySelectorAll('.wishlist-toggle-btn');
    wishlistBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const itemId = this.getAttribute('data-id');
            const icon = this.querySelector('i');
            
            // Animasi tekan
            this.style.transform = 'scale(1.2)';
            setTimeout(() => { this.style.transform = 'scale(1)'; }, 200);

            fetch('{{ route('user.wishlist.toggle') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ item_id: itemId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'added') {
                    icon.classList.remove('fa-regular');
                    icon.classList.add('fa-solid');
                    icon.style.color = '#ff4757'; // merah
                } else if (data.status === 'removed') {
                    icon.classList.remove('fa-solid');
                    icon.classList.add('fa-regular');
                    icon.style.color = '#95a5a6'; // abu-abu
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Silakan masuk (login) terlebih dahulu untuk menyimpan barang ke Favorit.');
            });
        });
    });
</script>
@endsection
