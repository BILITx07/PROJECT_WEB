@extends('layouts.user')

@section('title', 'Booking Saya - CampRent')

@section('content')
<h2 style="margin-top: 7rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.5rem; font-family: 'Outfit', sans-serif;">
    <i class="fa-solid fa-clock-rotate-left" style="color: var(--forest-green);"></i> Riwayat Booking Saya
</h2>

@if ($bookings->isEmpty())
    <div class="empty-state" style="padding: 3.5rem 2rem;">
        <!-- Beautiful SVG Camp Tent Vector Illustration -->
        <svg viewBox="0 0 500 220" width="100%" max-width="400px" style="display:block; margin: 0 auto 1.5rem auto;">
            <rect x="0" y="0" width="500" height="220" rx="20" fill="#FAF6EC" />
            <path d="M-50 220 C100 120, 200 180, 350 140 C450 110, 500 130, 550 130 L550 220 Z" fill="#E2DEC9" />
            <path d="M-20 220 C80 150, 180 200, 280 160 C380 120, 480 170, 520 180 L520 220 Z" fill="#D6CEB2" />
            <!-- Pine Trees -->
            <polygon points="120,160 100,190 140,190" fill="#4B6152" />
            <polygon points="120,140 105,170 135,170" fill="#587160" />
            <polygon points="120,120 110,150 130,150" fill="#65816E" />
            <rect x="117" y="190" width="6" height="15" fill="#3D2919" />
            
            <polygon points="380,150 365,180 395,180" fill="#4B6152" />
            <polygon points="380,130 370,160 390,160" fill="#587160" />
            <rect x="377" y="180" width="6" height="15" fill="#3D2919" />
            
            <!-- Glowing Orange Tent -->
            <polygon points="250,110 200,185 300,185" fill="#FF7A00" />
            <polygon points="250,110 250,185 300,185" fill="#E05A00" />
            <polygon points="250,140 225,185 275,185" fill="#0C2D1C" />
            <polygon points="250,140 240,185 225,185" fill="#FFA34D" />
            
            <!-- Small Campfire -->
            <circle cx="170" cy="195" r="8" fill="#505050" />
            <polygon points="170,182 165,195 175,195" fill="#FF4D00" />
            <polygon points="170,185 167,195 173,195" fill="#FF9E00" />
            
            <!-- Table/Chairs -->
            <rect x="315" y="170" width="16" height="15" fill="#3D2919" />
            <rect x="335" y="165" width="22" height="20" fill="#1F2E26" />
        </svg>
        <h3 style="font-size: 1.35rem; font-weight: 700; color: var(--text-dark); margin-bottom: 0.5rem;">Belum Ada Booking</h3>
        <p style="margin-bottom: 1.5rem; color: var(--text-muted); font-size: 0.95rem;">Anda belum melakukan pemesanan sewa barang apa pun.</p>
        <a href="{{ route('user.dashboard') }}" class="btn-checkout" style="display:inline-block; width:auto; padding: 0.85rem 2.5rem; background-color: var(--accent-orange); text-decoration:none; font-weight:700; border-radius:8px; color:white; font-size: 0.95rem;">Jelajah Alat Camping</a>
    </div>
@else
    <div class="bookings-list" style="display: flex; flex-direction: column; gap: 1rem;">
        @foreach ($bookings as $booking)
            @php
                $firstItem = $booking->items->first();
            @endphp
            <div class="booking-card-row" style="cursor: pointer;" onclick="window.location='{{ route('user.receipt', $booking->booking_code) }}'">
                <!-- Left: Product Image -->
                <div class="booking-card-img-wrapper">
                    @if ($firstItem && $firstItem->image)
                        <img src="{{ asset('storage/' . $firstItem->image) }}" alt="{{ $firstItem->name }}">
                    @else
                        <i class="fa-solid fa-tents fa-2x" style="color: var(--light-gray);"></i>
                    @endif
                </div>
                
                <!-- Middle: Booking details info -->
                <div class="booking-card-info">
                    <span class="booking-card-title">
                        {{ $booking->items->pluck('name')->join(', ') }}
                    </span>
                    <span class="booking-card-duration">
                        {{ $booking->duration }} hari
                    </span>
                    <span class="booking-card-dates">
                        {{ \Carbon\Carbon::parse($booking->start_date)->translatedFormat('d M Y') }} - 
                        {{ \Carbon\Carbon::parse($booking->end_date)->translatedFormat('d M Y') }}
                    </span>
                </div>
                
                <!-- Right: Price breakdown, status badge, and detail action -->
                <div class="booking-card-right-col">
                    <div class="booking-card-total-group">
                        <span class="booking-card-total-label">Total</span>
                        <span class="booking-card-total-val">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>
                    
                    <span class="status-badge {{ $booking->status }}">
                        {{ $booking->status }}
                    </span>

                    @if($booking->status === 'menunggu' && strtolower($booking->payment_method) === 'cod')
                        @php
                            $expiryTime = \Carbon\Carbon::parse($booking->created_at)->addHours(6);
                        @endphp
                        <div style="font-size: 0.8rem; color: #EF4444; font-weight: 600; text-align: right; margin-top: 0.5rem; background: rgba(239, 68, 68, 0.1); padding: 0.25rem 0.5rem; border-radius: 6px;">
                            Batal dalam <br><span class="cod-countdown" data-expire="{{ $expiryTime->timestamp }}"><i class="fa-solid fa-spinner fa-spin"></i></span>
                        </div>
                    @endif
                    
                    @if($booking->status === 'menunggu')
                        <form id="cancel-form-{{ $booking->booking_code }}" action="{{ route('user.bookings.cancel', $booking->booking_code) }}" method="POST" style="margin-top: 0.5rem; width: 100%;">
                            @csrf
                            <button type="button" onclick="event.stopPropagation(); if(confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')) document.getElementById('cancel-form-{{ $booking->booking_code }}').submit();" style="background: white; color: #EF4444; border: 1px solid #EF4444; padding: 0.4rem 1rem; border-radius: 6px; font-weight: 600; cursor: pointer; width: 100%; transition: 0.3s; font-size:0.85rem; text-align:center;" onmouseover="this.style.background='#FEF2F2'" onmouseout="this.style.background='white'">Batalkan</button>
                        </form>
                    @endif
                    
                    <span class="booking-card-btn-detail" style="margin-top: 0.25rem;">
                        Detail
                    </span>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const timers = document.querySelectorAll('.cod-countdown');
    
    if(timers.length > 0) {
        const interval = setInterval(() => {
            const now = Math.floor(Date.now() / 1000);
            timers.forEach(timer => {
                const expire = parseInt(timer.getAttribute('data-expire'));
                const diff = expire - now;
                
                if(diff <= 0) {
                    timer.innerHTML = "Dibatalkan";
                    timer.parentElement.style.color = '#EF4444';
                    // Reload page immediately when time is up
                    setTimeout(() => location.reload(), 2000);
                } else {
                    const hours = Math.floor(diff / 3600);
                    const minutes = Math.floor((diff % 3600) / 60);
                    const seconds = diff % 60;
                    
                    timer.innerHTML = 
                        (hours < 10 ? "0" : "") + hours + ":" + 
                        (minutes < 10 ? "0" : "") + minutes + ":" + 
                        (seconds < 10 ? "0" : "") + seconds;
                }
            });
        }, 1000);
    }
});
</script>
@endsection
