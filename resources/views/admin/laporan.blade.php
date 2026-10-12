@extends('layouts.admin')

@section('title', 'Laporan')
@section('page-title', 'Laporan')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px;">
    <h2 style="font-size:22px;font-weight:700; margin:0;">Laporan</h2>
    <div style="display:flex; gap:10px;">
        <form action="{{ route('admin.laporan') }}" method="GET" style="display:flex; gap:10px; align-items:center; margin:0;">
            <input type="month" name="month" value="{{ $monthFilter ?? '' }}" style="padding: 8px 12px; border: 1px solid #ccc; border-radius: 8px; font-family: inherit; font-size: 14px;">
            <button type="submit" style="padding: 8px 16px; background: #FF7A00; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 14px;">Tampilkan</button>
            @if($monthFilter)
                <a href="{{ route('admin.laporan') }}" style="padding: 8px 16px; background: #f3f4f6; color: #374151; border: 1px solid #d1d5db; border-radius: 8px; font-weight: 600; text-decoration: none; font-size: 14px;">Reset</a>
            @endif
        </form>
        <a href="{{ route('admin.laporan.export', ['month' => $monthFilter]) }}" target="_blank" style="padding: 8px 16px; background: #EF4444; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; text-decoration: none; display: flex; align-items: center; gap: 8px; font-size: 14px; transition: 0.2s;" onmouseover="this.style.background='#DC2626'" onmouseout="this.style.background='#EF4444'">
            <i class="fa-solid fa-file-pdf"></i> Download PDF
        </a>
    </div>
</div>

{{-- Stats grid --}}
<div class="laporan-grid">
  <div class="laporan-stat money">
    <div class="ls-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
    <div class="ls-label">Total Pendapatan</div>
  </div>
  <div class="laporan-stat">
    <div class="ls-value">{{ $bookingSelesai }}</div>
    <div class="ls-label">Booking Selesai</div>
  </div>
  <div class="laporan-stat">
    <div class="ls-value">{{ $bookingAktif }}</div>
    <div class="ls-label">Booking Aktif (Dikonfirmasi)</div>
  </div>
  <div class="laporan-stat">
    <div class="ls-value">{{ $bookingBatal }}</div>
    <div class="ls-label">Booking Dibatalkan</div>
  </div>
</div>

{{-- Monthly table --}}
<div class="card" style="padding:0;">
  <div style="padding:16px 18px 10px;font-size:16px;font-weight:700;">Ringkasan Per Bulan</div>
  <table class="laporan-table">
    <thead>
      <tr>
        <th>Bulan</th>
        <th>Total Booking</th>
        <th>Pendapatan</th>
      </tr>
    </thead>
    <tbody>
      @forelse($monthlyStats as $row)
        <tr>
          <td class="fw-600">{{ $row->bulan }}</td>
          <td>{{ $row->total }}</td>
          <td class="fw-600" style="color:var(--text-orange);">Rp {{ number_format($row->pendapatan, 0, ',', '.') }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="3" class="text-center text-muted" style="padding:30px;">Belum ada data</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

{{-- Recent bookings --}}
<h3 style="font-size:16px;font-weight:700;margin:20px 0 12px;">Riwayat Booking Terbaru</h3>
<div class="card" style="padding:0 20px;">
  @forelse($recentBookings as $booking)
    @php
      $start = $booking->start_date->translatedFormat('j M Y');
      $end   = $booking->end_date->translatedFormat('j M Y');
    @endphp
    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="booking-row">
      <div class="booking-row-left">
        <div class="booking-code">{{ $booking->booking_code }}</div>
        <div class="booking-name">{{ $booking->customer_name }}</div>
        <div class="booking-date">{{ $start }} – {{ $end }}</div>
      </div>
      <div class="booking-row-right">
        <div class="booking-amount">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
        <span class="badge badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
      </div>
    </a>
  @empty
    <div class="empty-state"><i class="fa-regular fa-folder-open"></i><p>Belum ada data</p></div>
  @endforelse
</div>

@endsection
