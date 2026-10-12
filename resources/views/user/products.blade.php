@extends('layouts.user')

@section('title', 'Jelajah Barang - CampRent')

@section('hero')
<!-- Products Hero Banner -->
<div class="products-hero">
    <h1 style="color: #ffffff; font-size: 3.5rem; font-weight: 800; font-family: 'Urbanist', sans-serif; text-shadow: 0 4px 15px rgba(0,0,0,0.5); text-align: center; margin: 0; letter-spacing: 1px;">DAFTAR PERALATAN</h1>
    <p style="color: #e5e7eb; font-size: 1.1rem; margin-top: 0.5rem; text-shadow: 0 2px 5px rgba(0,0,0,0.5); font-weight: 500;">Temukan gear terbaik untuk melengkapi petualangan Anda.</p>
</div>
@endsection

@section('content')
@if(!isset($isProductsPage) || !$isProductsPage)
<!-- Hero Section with Search -->
<div class="hero-section">
    <div class="hero-content" style="max-width: 1200px; margin: 0 auto; width: 100%; padding-top: 2rem;">
        <span class="hero-subtitle" style="color: #4ade80; font-weight: 600; font-size: 1.2rem; letter-spacing: 0.5px; display: block; margin-bottom: 0.5rem; text-shadow: 0 1px 2px rgba(0,0,0,0.5);">
            Siap Menjelajah, Tanpa Ribet.
        </span>
        <h1 class="hero-title-main" style="color: #ffffff; font-size: 3.5rem; font-weight: 800; line-height: 1.1; margin-bottom: 2rem; max-width: 800px; text-shadow: 0 2px 10px rgba(0,0,0,0.5); text-align: left;">
            Sewa Gear Outdoor<br>Kini Lebih Mudah!
        </h1>
        
        <div class="hero-checklist" style="display: flex; flex-wrap: wrap; gap: 1.5rem; margin-bottom: 3.5rem;">
            <div class="check-item" style="display: flex; align-items: center; gap: 0.5rem; font-weight: 600; text-shadow: 0 1px 3px rgba(0,0,0,0.5); font-size: 1.05rem;">
                <i class="fa-solid fa-circle-check" style="color: #4ade80; font-size: 1.25rem;"></i>
                <span>Stok Real-Time & Lengkap</span>
            </div>
            <div class="check-item" style="display: flex; align-items: center; gap: 0.5rem; font-weight: 600; text-shadow: 0 1px 3px rgba(0,0,0,0.5); font-size: 1.05rem;">
                <i class="fa-solid fa-circle-check" style="color: #4ade80; font-size: 1.25rem;"></i>
                <span>Praktis & Cepat</span>
            </div>
            <div class="check-item" style="display: flex; align-items: center; gap: 0.5rem; font-weight: 600; text-shadow: 0 1px 3px rgba(0,0,0,0.5); font-size: 1.05rem;">
                <i class="fa-solid fa-circle-check" style="color: #4ade80; font-size: 1.25rem;"></i>
                <span>Layanan Khusus PONTIANAK</span>
            </div>
        </div>

    </div>
</div>
@endif

<!-- Products Layout (2-Column) -->
<div class="products-layout" style="max-width: 1200px; margin: 4rem auto 2rem auto; padding: 0 1.5rem; display: grid; grid-template-columns: 250px 1fr; gap: 2rem; align-items: start;">
    <!-- Sidebar Kategori -->
    <aside class="category-sidebar">
        <div style="background: #ffffff; border-radius: 12px; border: 1px solid #eaeaea; box-shadow: 0 4px 6px rgba(0,0,0,0.02); padding: 1.5rem; position: sticky; top: 100px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #111827; margin: 0;">Kategori</h3>
                <i class="fa-solid fa-chevron-down" style="color: #6b7280; font-size: 0.8rem;"></i>
            </div>
            
            <form id="categoryFilterForm" action="{{ (!isset($isProductsPage) || !$isProductsPage) ? route('user.dashboard') : route('user.products') }}" method="GET">
                <input type="hidden" name="start_date" value="{{ $startDate }}">
                <input type="hidden" name="end_date" value="{{ $endDate }}">
                <input type="hidden" name="q" value="{{ $search }}">
                
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    @if(isset($allCategories))
                        @foreach($allCategories as $category)
                        <label style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer;">
                            <input type="checkbox" name="categories[]" value="{{ $category }}" 
                                   {{ (isset($selectedCategories) && in_array($category, $selectedCategories)) ? 'checked' : '' }}
                                   onchange="document.getElementById('categoryFilterForm').submit()"
                                   style="width: 18px; height: 18px; border-radius: 4px; border: 1px solid #d1d5db; accent-color: #4ade80; cursor: pointer;">
                            <span style="font-size: 0.95rem; color: #4b5563;">{{ $category }}</span>
                        </label>
                        @endforeach
                    @endif
                </div>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="products-main">
        <!-- Search Bar untuk barang -->
        <div style="margin-bottom: 2rem;">
            <form action="{{ (!isset($isProductsPage) || !$isProductsPage) ? route('user.dashboard') : route('user.products') }}" method="GET" style="display: flex; width: 100%; border: 1px solid #eaeaea; border-radius: 8px; overflow: hidden; background: #fff;">
                <input type="hidden" name="start_date" value="{{ $startDate }}">
                <input type="hidden" name="end_date" value="{{ $endDate }}">
                @if(isset($selectedCategories) && is_array($selectedCategories))
                    @foreach($selectedCategories as $cat)
                        <input type="hidden" name="categories[]" value="{{ $cat }}">
                    @endforeach
                @endif
                
                <div style="padding: 0.75rem 1rem; color: #6b7280; background: #f9fafb;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari barang" style="border: none; outline: none; width: 100%; padding: 0.75rem 1rem 0.75rem 0.5rem; font-size: 0.95rem;">
            </form>
        </div>

        <!-- Product Listings -->
        <div class="product-grid">
    @forelse ($items as $item)
        <div class="product-card" style="position: relative;">
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
    </main>
</div>

<!-- Kenapa Memilih CAMPrent Section -->
<div class="why-us-section">
    <h3 class="why-us-title">Kenapa Memilih CAMPrent?</h3>
    <div class="why-us-grid">
        <div class="why-us-card">
            <div class="why-us-icon-container">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div class="why-us-info">
                <h4 class="why-us-card-title">Barang Berkualitas</h4>
                <p class="why-us-card-desc">Semua peralatan kami terawat dan terbaik</p>
            </div>
        </div>
        <div class="why-us-card">
            <div class="why-us-icon-container">
                <i class="fa-solid fa-tags"></i>
            </div>
            <div class="why-us-info">
                <h4 class="why-us-card-title">Harga Terjangkau</h4>
                <p class="why-us-card-desc">Harga sewa bersaing dan transparan</p>
            </div>
        </div>
        <div class="why-us-card">
            <div class="why-us-icon-container">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div class="why-us-info">
                <h4 class="why-us-card-title">Booking Mudah</h4>
                <p class="why-us-card-desc">Proses pemesanan cepat dan praktis</p>
            </div>
        </div>
        <div class="why-us-card">
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
