@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'dashboard')

@section('content')

{{-- ── Booking Terbaru (Mockup style on top) ─────────────────── --}}
<div style="margin-bottom: 2rem;">
    <h3 style="font-size: 1.45rem; font-weight: 700; color: var(--forest-green); font-family: 'Outfit', sans-serif; margin-bottom: 0.25rem;">Booking Terbaru</h3>
    <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1.25rem;">Daftar booking terakhir yang masuk</p>

    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
        @forelse($recentBookings as $booking)
            @php
                $firstItem = $booking->items->first();
                $start = $booking->start_date->translatedFormat('d M');
                $end = $booking->end_date->translatedFormat('d M');
            @endphp
            <div style="background: #FFFFFF; border: 1px solid #ECE7DD; border-radius: 12px; padding: 1.25rem; display: flex; gap: 1.25rem; position: relative; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                
                <!-- Left column: Item Image thumbnail -->
                <div style="width: 100px; height: 100px; border-radius: 8px; border: 1px solid #ECE7DD; display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0; background-color: #FFFFFF;">
                    @if ($firstItem && $firstItem->image)
                        <img src="{{ asset('storage/' . $firstItem->image) }}" alt="{{ $firstItem->name }}" style="max-width: 90%; max-height: 90%; object-fit: contain;">
                    @else
                        <i class="fa-solid fa-tents fa-2x" style="color: var(--text-muted); opacity: 0.3;"></i>
                    @endif
                </div>

                <!-- Right column: booking info -->
                <div style="flex: 1; display: flex; flex-direction: column; justify-content: center; gap: 0.65rem;">
                    <h4 style="font-size: 0.95rem; font-weight: 700; color: #1F2E26; margin: 0; padding-right: 2rem;">
                        {{ $booking->booking_code ?? 'Booking #0012X' }} ({{ $booking->customer_name }})
                    </h4>
                    
                    <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.8rem; color: var(--text-muted); font-weight: 500;">
                        <i class="fa-solid fa-calendar-days" style="font-size: 0.9rem;"></i> 
                        {{ $start }} - {{ $end }}
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 0.35rem; font-size: 0.85rem;">
                        <span style="color: var(--text-muted);">Status:</span> 
                        @if(strtolower($booking->status) == 'dikonfirmasi')
                            <span style="background: #34A853; color: white; padding: 2px 10px; border-radius: 12px; font-weight: 600; font-size: 0.65rem; text-transform: uppercase;">Dikonfirmasi</span>
                        @elseif(strtolower($booking->status) == 'dibayar')
                            <span style="background: #3B82F6; color: white; padding: 2px 10px; border-radius: 12px; font-weight: 600; font-size: 0.65rem; text-transform: uppercase;">Dibayar</span>
                        @elseif(strtolower($booking->status) == 'diproses')
                            <span style="background: #F5B000; color: white; padding: 2px 10px; border-radius: 12px; font-weight: 600; font-size: 0.65rem; text-transform: uppercase;">Diproses</span>
                        @elseif(strtolower($booking->status) == 'menunggu')
                            <span style="background: #FF7A00; color: white; padding: 2px 10px; border-radius: 12px; font-weight: 600; font-size: 0.65rem; text-transform: uppercase;">Menunggu</span>
                        @elseif(strtolower($booking->status) == 'selesai')
                            <span style="background: #6B7C73; color: white; padding: 2px 10px; border-radius: 12px; font-weight: 600; font-size: 0.65rem; text-transform: uppercase;">Selesai</span>
                        @else
                            <span style="background: #FF7A00; color: white; padding: 2px 10px; border-radius: 12px; font-weight: 600; font-size: 0.65rem; text-transform: uppercase;">{{ $booking->status }}</span>
                        @endif
                    </div>
                    
                    <div style="font-size: 0.9rem; font-weight: 700; color: #1F2E26; margin-top: 0.1rem;">
                        Total: Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                    </div>
                </div>
                
                <!-- Detail Eye Icon Button -->
                <a href="{{ route('admin.bookings.show', $booking->id) }}" style="position: absolute; top: 1.25rem; right: 1.25rem; background: #F8F5EE; border: none; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); transition: all 0.2s ease; cursor: pointer;">
                    <i class="fa-regular fa-eye" style="font-size: 0.9rem;"></i>
                </a>
            </div>
        @empty
            <div class="empty-state" style="grid-column: span 2; background-color: white; border-radius: 16px; border: 1px solid #ECE7DD; box-shadow: 0 4px 15px rgba(0,0,0,0.02); padding: 3rem;">
                <i class="fa-regular fa-folder-open fa-3x" style="color: var(--text-muted); margin-bottom: 1rem; display:block;"></i>
                <p>Belum ada data booking.</p>
            </div>
        @endforelse
    </div>

    @if(!$recentBookings->isEmpty())
        <div style="text-align:center; margin-top: 1.5rem;">
            <a href="{{ route('admin.bookings.index') }}" style="font-size: 0.9rem; font-weight: 700; color: var(--forest-green); text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem;">
                Lihat Semua Booking <i class="fa-solid fa-chevron-down" style="font-size: 0.8rem;"></i>
            </a>
        </div>
    @endif
</div>

{{-- ── Stats Cards Grid (Mockup style at the bottom) ─────────── --}}
@php
    $waitingCount = \App\Models\Booking::where('status', 'menunggu')->count();
    $completedCount = \App\Models\Booking::where('status', 'selesai')->count();
@endphp
<div class="stats-grid-mockup">
    <!-- Stat Card 1 -->
    <div class="stat-card-mockup">
        <div class="stat-card-icon-container total-booking">
            <i class="fa-regular fa-calendar-days"></i>
        </div>
        <div class="stat-card-info-group">
            <span class="stat-card-label">Total Booking</span>
            <span class="stat-card-value">{{ $totalBookings }}</span>
            <span class="stat-card-trend up"><i class="fa-solid fa-arrow-up"></i> +12 dari bulan lalu</span>
        </div>
    </div>

    <!-- Stat Card 2 -->
    <div class="stat-card-mockup">
        <div class="stat-card-icon-container pendapatan">
            <i class="fa-solid fa-wallet"></i>
        </div>
        <div class="stat-card-info-group">
            <span class="stat-card-label">Pendapatan</span>
            <span class="stat-card-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
            <span class="stat-card-trend up"><i class="fa-solid fa-arrow-up"></i> +18% dari bulan lalu</span>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div class="stat-card-mockup">
        <div class="stat-card-icon-container menunggu">
            <i class="fa-regular fa-clock"></i>
        </div>
        <div class="stat-card-info-group">
            <span class="stat-card-label">Menunggu</span>
            <span class="stat-card-value">{{ $waitingCount }}</span>
            <span class="stat-card-trend neutral">Perlu konfirmasi</span>
        </div>
    </div>

    <!-- Stat Card 4 -->
    <div class="stat-card-mockup">
        <div class="stat-card-icon-container selesai">
            <i class="fa-regular fa-circle-check"></i>
        </div>
        <div class="stat-card-info-group">
            <span class="stat-card-label">Selesai</span>
            <span class="stat-card-value">{{ $completedCount }}</span>
            <span class="stat-card-trend neutral">Booking selesai</span>
        </div>
    </div>
</div>

<div style="margin-top: 3rem; font-size: 0.8rem; color: var(--text-muted); opacity: 0.8;">
    &copy; {{ date('Y') }} CAMPrent Admin Panel. All rights reserved.
</div>

@endsection
