@extends('layouts.admin')

@section('title', 'Detail Booking')
@section('page-title', 'detail booking')

@section('content')

@php
  $days   = max(1, $booking->start_date->diffInDays($booking->end_date));
  $start  = $booking->start_date->translatedFormat('j M Y');
  $end    = $booking->end_date->translatedFormat('j M Y');
@endphp

{{-- Back link --}}
<a href="{{ route('admin.bookings.index') }}"
   style="display:inline-flex;align-items:center;gap:6px;font-size:13px;color:var(--text-muted);margin-bottom:14px;">
  <i class="fa-solid fa-arrow-left"></i> Kembali ke Data Booking
</a>

<h2 style="font-size:22px;font-weight:700;margin-bottom:18px;">Detail Booking</h2>

{{-- ── Informasi Pelanggan ──────────────────────────── --}}
<div class="detail-section">
  <div class="detail-field">
    <div class="detail-field-label" style="padding-top:14px;">Nama Lengkap</div>
    <div class="detail-field-value">{{ $booking->customer_name }}</div>
  </div>
  <div class="detail-field">
    <div class="detail-field-label">No WhatsApp</div>
    <div class="detail-field-value">{{ $booking->phone_number ?? '–' }}</div>
  </div>
</div>

{{-- ── Periode Sewa ─────────────────────────────────── --}}
<div class="detail-section">
  <div class="detail-section-title">Periode Sewa</div>
  <div class="detail-period-grid">
    <div class="detail-field" style="padding-bottom:14px;">
      <div class="detail-field-label">Tanggal Pinjam</div>
      <div class="detail-field-value">{{ $start }}</div>
    </div>
    <div class="detail-period-divider">–</div>
    <div class="detail-field" style="padding-bottom:14px;">
      <div class="detail-field-label">Tanggal Kembali</div>
      <div class="detail-field-value">{{ $end }}</div>
    </div>
  </div>
  <div class="detail-field" style="padding-top:0;border-top:1px solid #f5f2ed;padding-top:12px;">
    <div class="detail-field-label">Durasi Sewa</div>
    <div class="detail-field-value">{{ $days }} Hari</div>
  </div>
</div>

{{-- ── Informasi Pembayaran ─────────────────────────── --}}
<div class="detail-section">
  <div class="detail-section-title">Informasi Pembayaran</div>
  <div class="detail-field">
    <div class="detail-field-label" style="padding-top:14px;">Metode Pembayaran</div>
    <div class="detail-field-value" style="font-weight: 700;">
        @if($booking->payment_method === 'qris')
            <span style="color: #00A651;"><i class="fa-solid fa-qrcode"></i> QRIS</span>
        @elseif($booking->payment_method === 'transfer_bca')
            <span style="color: #0066AE;"><i class="fa-solid fa-building-columns"></i> Transfer Bank BCA</span>
        @elseif($booking->payment_method === 'transfer_mandiri')
            <span style="color: #F2A900;"><i class="fa-solid fa-building-columns"></i> Transfer Bank Mandiri</span>
        @else
            Bayar di Tempat (COD)
        @endif
    </div>
  </div>
  @if($booking->payment_proof)
  <div class="detail-field">
    <div class="detail-field-label">Bukti Pembayaran</div>
    <div class="detail-field-value" style="margin-top: 0.5rem;">
        <a href="{{ asset('storage/' . $booking->payment_proof) }}" target="_blank" style="display:inline-block; border: 1px solid #ECE7DD; border-radius: 8px; overflow: hidden; text-decoration: none;">
            <img src="{{ asset('storage/' . $booking->payment_proof) }}" alt="Bukti Pembayaran" style="max-width: 250px; display: block; object-fit: contain;">
            <div style="background: #F8F5EE; text-align: center; font-size: 0.75rem; padding: 6px; color: var(--text-muted); font-weight: 600;"><i class="fa-solid fa-expand"></i> Klik untuk perbesar</div>
        </a>
    </div>
  </div>
  @else
  <div class="detail-field">
    <div class="detail-field-label">Bukti Pembayaran</div>
    <div class="detail-field-value" style="color: var(--text-muted); font-style: italic;">
        Belum ada bukti pembayaran diunggah.
    </div>
  </div>
  @endif
</div>

{{-- ── Barang yang di Sewa ──────────────────────────── --}}
<div class="detail-section">
  <div class="detail-section-title">Barang yang di sewa</div>

  @foreach($booking->bookingItems as $bi)
    <div class="detail-item-row">
      <div class="detail-item-thumb">
        @if($bi->item->image)
          <img src="{{ asset('storage/' . $bi->item->image) }}" alt="{{ $bi->item->name }}">
        @else
          <span style="font-size:22px;">
            @if(str_contains(strtolower($bi->item->category), 'tenda')) ⛺
            @elseif(str_contains(strtolower($bi->item->category), 'tas')) 🎒
            @elseif(str_contains(strtolower($bi->item->category), 'masak')) 🍳
            @else 🏕️
            @endif
          </span>
        @endif
      </div>
      <div style="flex:1;min-width:0;">
        <div class="detail-item-name">{{ $bi->item->name }}</div>
        <div class="detail-item-price">Rp {{ number_format($bi->price_per_day, 0, ',', '.') }} /hari</div>
      </div>
    </div>
  @endforeach
</div>

{{-- ── Ringkasan Sewa ───────────────────────────────── --}}
<div class="detail-section">
  <div class="detail-section-title">Ringkasan Sewa</div>

  @foreach($booking->bookingItems as $bi)
    <div class="summary-row">
      <span>{{ $bi->item->name }} ({{ $bi->quantity }}x)</span>
      <span>Rp {{ number_format($bi->price_per_day * $bi->quantity, 0, ',', '.') }}</span>
    </div>
  @endforeach

  <div class="summary-row">
    <span>Durasi sewa ({{ $days }} hari)</span>
    <span>×{{ $days }}</span>
  </div>

  <div class="summary-row total">
    <span>Total Pembayaran</span>
    <span style="color:var(--text-orange);">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
  </div>
</div>

{{-- ── Action Buttons ───────────────────────────────── --}}
<div class="detail-actions" style="padding-bottom:10px;">
  @if($booking->status === 'menunggu')
    {{-- Konfirmasi --}}
    <button type="button" class="btn btn-success btn-full"
            onclick="openPopup('popup-konfirm')">
      Konfirmasi
    </button>
    {{-- Batalkan --}}
    <button type="button" class="btn btn-danger btn-full"
            onclick="openPopup('popup-batal')">
      Batalkan
    </button>
    {{-- Selesai (disabled) --}}
    <button class="btn btn-full" disabled style="background:#e0e0e0;color:#aaa;cursor:not-allowed;">
      Tandai Selesai
    </button>

  @elseif($booking->status === 'dikonfirmasi')
    {{-- Sedang Disewa (Serahkan Barang) --}}
    <button type="button" class="btn btn-primary btn-full"
            onclick="openPopup('popup-serahkan')">
      Serahkan Barang (Sedang Disewa)
    </button>
    {{-- Batalkan --}}
    <button type="button" class="btn btn-danger btn-full"
            onclick="openPopup('popup-batal')">
      Batalkan
    </button>
    {{-- Selesai (disabled) --}}
    <button class="btn btn-full" disabled style="background:#e0e0e0;color:#aaa;cursor:not-allowed;">
      Tandai Selesai
    </button>

  @elseif($booking->status === 'sedang_disewa')
    {{-- Selesai --}}
    <button type="button" class="btn btn-warning btn-full"
            onclick="openPopup('popup-selesai')">
      Tandai Selesai
    </button>

  @else
    <div style="grid-column:1/-1;text-align:center;">
      <span class="badge badge-{{ $booking->status }}" style="font-size:14px;padding:8px 20px;">
        {{ ucwords(str_replace('_', ' ', $booking->status)) }}
      </span>
      <p style="font-size:13px;color:var(--text-muted);margin-top:8px;">
        Booking ini sudah {{ $booking->status }} dan tidak dapat diubah.
      </p>
    </div>
  @endif
</div>


{{-- ════════════════════════════════════════════════════ --}}
{{-- ── POPUP: Konfirmasi Booking ──────────────────── --}}
{{-- ════════════════════════════════════════════════════ --}}
<div class="popup-overlay" id="popup-konfirm">
  <div class="popup-card">
    <div class="popup-icon popup-icon--success">
      <i class="fa-solid fa-check"></i>
    </div>
    <h3 class="popup-title">Konfirmasi Booking?</h3>
    <p class="popup-desc">Booking akan diterima dan barang<br>disiapkan untuk penyewa.</p>
    <div class="popup-actions">
      <button type="button" class="popup-btn popup-btn--cancel" onclick="closePopup('popup-konfirm')">
        Batal
      </button>
      <form action="{{ route('admin.bookings.confirm', $booking->id) }}" method="POST" style="flex:1;">
        @csrf @method('PATCH')
        <button type="submit" class="popup-btn popup-btn--confirm popup-btn--green btn-full">
          Ya, konfirmasi
        </button>
      </form>
    </div>
  </div>
</div>

{{-- ════════════════════════════════════════════════════ --}}
{{-- ── POPUP: Batalkan Booking ────────────────────── --}}
{{-- ════════════════════════════════════════════════════ --}}
<div class="popup-overlay" id="popup-batal">
  <div class="popup-card">
    <div class="popup-icon popup-icon--danger">
      <i class="fa-solid fa-xmark"></i>
    </div>
    <h3 class="popup-title">Konfirmasi Booking?</h3>
    <p class="popup-desc">Booking akan dibatalkan dan stok barang&nbsp; dikembalikan</p>
    <div class="popup-actions">
      <button type="button" class="popup-btn popup-btn--cancel" onclick="closePopup('popup-batal')">
        Batal
      </button>
      <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST" style="flex:1;">
        @csrf @method('PATCH')
        <button type="submit" class="popup-btn popup-btn--confirm popup-btn--red btn-full">
          Batalkan
        </button>
      </form>
    </div>
  </div>
</div>

{{-- ════════════════════════════════════════════════════ --}}
{{-- ── POPUP: Serahkan Barang (Sedang Disewa) ────────── --}}
{{-- ════════════════════════════════════════════════════ --}}
<div class="popup-overlay" id="popup-serahkan">
  <div class="popup-card">
    <div class="popup-icon popup-icon--primary" style="background: rgba(0, 123, 255, 0.1); color: #007bff;">
      <i class="fa-solid fa-people-carry-box"></i>
    </div>
    <h3 class="popup-title">Serahkan Barang?</h3>
    <p class="popup-desc">Ubah status menjadi "Sedang Disewa" saat barang sudah diserahkan ke penyewa.</p>
    <div class="popup-actions">
      <button type="button" class="popup-btn popup-btn--cancel" onclick="closePopup('popup-serahkan')">
        Batal
      </button>
      <form action="{{ route('admin.bookings.pickup', $booking->id) }}" method="POST" style="flex:1;">
        @csrf @method('PATCH')
        <button type="submit" class="popup-btn popup-btn--confirm popup-btn--blue btn-full">
          Ya, Serahkan
        </button>
      </form>
    </div>
  </div>
</div>

{{-- ════════════════════════════════════════════════════ --}}
{{-- ── POPUP: Tandai Selesai ──────────────────────── --}}
{{-- ════════════════════════════════════════════════════ --}}
<div class="popup-overlay" id="popup-selesai">
  <div class="popup-card">
    <div class="popup-icon popup-icon--blue">
      <i class="fa-solid fa-check"></i>
    </div>
    <h3 class="popup-title">Selesaikan Booking?</h3>
    <p class="popup-desc">Penyewa sudah mengembalikan<br>seluruh barang.</p>
    <div class="popup-actions">
      <button type="button" class="popup-btn popup-btn--cancel" onclick="closePopup('popup-selesai')">
        Batal
      </button>
      <form action="{{ route('admin.bookings.complete', $booking->id) }}" method="POST" style="flex:1;">
        @csrf @method('PATCH')
        <button type="submit" class="popup-btn popup-btn--confirm popup-btn--blue btn-full">
          Ya, Selesai
        </button>
      </form>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<style>
  /* ── Popup Overlay ────────────────────────────────── */
  .popup-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.45);
    backdrop-filter: blur(4px);
    z-index: 9000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    opacity: 0;
    pointer-events: none;
    transition: opacity .25s ease;
  }

  .popup-overlay.show {
    opacity: 1;
    pointer-events: auto;
  }

  /* ── Popup Card ───────────────────────────────────── */
  .popup-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 36px 28px 28px;
    width: 100%;
    max-width: 320px;
    text-align: center;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    transform: scale(0.92) translateY(10px);
    transition: transform .28s cubic-bezier(0.34, 1.56, 0.64, 1);
  }

  .popup-overlay.show .popup-card {
    transform: scale(1) translateY(0);
  }

  /* ── Icon ─────────────────────────────────────────── */
  .popup-icon {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 30px;
  }

  .popup-icon--success { background: #2e7d32; color: #fff; }
  .popup-icon--danger  { background: #c62828; color: #fff; }
  .popup-icon--blue    { background: #1565c0; color: #fff; }

  /* ── Text ─────────────────────────────────────────── */
  .popup-title {
    font-size: 18px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 10px;
  }

  .popup-desc {
    font-size: 13px;
    color: #7a7a7a;
    line-height: 1.6;
    margin-bottom: 24px;
  }

  /* ── Popup Buttons ────────────────────────────────── */
  .popup-actions {
    display: flex;
    gap: 10px;
    align-items: stretch;
  }

  .popup-btn {
    flex: 1;
    padding: 11px 16px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    border: none;
    transition: all .18s ease;
  }

  .popup-btn--cancel {
    background: transparent;
    color: #555;
    border: 1.5px solid #ddd;
  }

  .popup-btn--cancel:hover {
    background: #f5f5f5;
  }

  .popup-btn--confirm {
    color: #fff;
    border: none;
  }

  .popup-btn--green { background: #2e7d32; }
  .popup-btn--green:hover { background: #1b5e20; }

  .popup-btn--red   { background: #c62828; }
  .popup-btn--red:hover { background: #b71c1c; }

  .popup-btn--blue  { background: #1565c0; }
  .popup-btn--blue:hover { background: #0d47a1; }
</style>

<script>
  function openPopup(id) {
    document.getElementById(id).classList.add('show');
    document.body.style.overflow = 'hidden';
  }

  function closePopup(id) {
    document.getElementById(id).classList.remove('show');
    document.body.style.overflow = '';
  }

  // Close on backdrop click
  document.querySelectorAll('.popup-overlay').forEach(el => {
    el.addEventListener('click', function(e) {
      if (e.target === this) closePopup(this.id);
    });
  });

  // Close with Escape key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      document.querySelectorAll('.popup-overlay.show').forEach(el => {
        closePopup(el.id);
      });
    }
  });
</script>
@endsection

