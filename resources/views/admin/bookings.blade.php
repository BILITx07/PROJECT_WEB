@extends('layouts.admin')

@section('title', 'Data Booking')
@section('page-title', 'Data Booking')

@section('content')

<div class="page-header">
  <h2>Data Booking</h2>
  <button class="btn btn-success btn-sm" onclick="openCreateModal()">+ Tambah Booking</button>
</div>

{{-- Search --}}
<form method="GET" action="{{ route('admin.bookings.index') }}" id="filter-form">
  <div class="search-wrap mb-16">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input type="text" name="search" class="search-input"
           placeholder="Cari pelanggan atau kode booking..."
           value="{{ request('search') }}"
           onchange="document.getElementById('filter-form').submit()">
    <input type="hidden" name="status" id="status-hidden" value="{{ $statusTab ?? 'menunggu_transfer' }}">
  </div>
</form>

{{-- Tab Filter --}}
@php
  $activeTab = $statusTab ?? 'menunggu_transfer';
  $tabs = [
    'menunggu_transfer' => 'Menunggu Transfer',
    'menunggu_cod'      => 'Menunggu Diambil (COD)',
    'riwayat'           => 'Riwayat Pesanan',
  ];
@endphp
<div class="tab-filter mb-16">
  @foreach($tabs as $val => $label)
    <a href="{{ route('admin.bookings.index', ['status' => $val, 'search' => request('search')]) }}"
       class="{{ $activeTab === $val ? 'active' : '' }}">
      {{ $label }}
    </a>
  @endforeach
</div>

{{-- Booking Cards --}}
<div class="card" style="padding: 0 20px;">
  @forelse($bookings as $booking)
    @php
      $days  = max(1, $booking->start_date->diffInDays($booking->end_date));
      $start = $booking->start_date->translatedFormat('j M Y');
      $end   = $booking->end_date->translatedFormat('j M Y');
    @endphp
    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="booking-row">
      <div class="booking-row-left">
        <div class="booking-code">{{ $booking->booking_code }}</div>
        <div class="booking-name">{{ $booking->customer_name }}</div>
        <div class="booking-date">{{ $start }} – {{ $end }}</div>
        <div class="booking-date">{{ $days }} hari</div>
      </div>
      <div class="booking-row-right">
        <div class="booking-amount">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
        <span class="badge badge-{{ $booking->status }}">{{ ucwords(str_replace('_', ' ', $booking->status)) }}</span>
      </div>
    </a>
  @empty
    <div class="empty-state" style="padding: 40px;">
      <i class="fa-regular fa-folder-open"></i>
      <p>Tidak ada data booking untuk filter ini.</p>
    </div>
  @endforelse
</div>


{{-- ── Modal Tambah Booking ───────────────────────── --}}
<div class="modal-backdrop" id="create-modal">
  <div class="modal-box">
    <div class="modal-head">
      <span>Tambah Booking Baru</span>
      <button onclick="closeModal('create-modal')">&times;</button>
    </div>
    <form action="{{ route('admin.bookings.store') }}" method="POST">
      @csrf
      <div class="modal-body">
        <div class="form-group">
          <label class="form-label">Nama Pelanggan</label>
          <input type="text" name="customer_name" class="form-control" placeholder="Nama lengkap" required>
        </div>
        <div class="form-group">
          <label class="form-label">No. WhatsApp</label>
          <input type="text" name="phone_number" class="form-control" placeholder="08xxxxxxxxxx">
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Tanggal Pinjam</label>
            <input type="date" name="start_date" class="form-control" value="{{ date('Y-m-d') }}" required>
          </div>
          <div class="form-group">
            <label class="form-label">Tanggal Kembali</label>
            <input type="date" name="end_date" class="form-control" value="{{ date('Y-m-d', strtotime('+2 days')) }}" required>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Barang yang Disewa</label>
          <div id="item-list">
            <div class="item-entry" style="display:flex;gap:8px;margin-bottom:8px;">
              <select name="item_ids[]" class="form-control" required style="flex:3;">
                <option value="">Pilih Barang</option>
                @foreach($items as $item)
                  <option value="{{ $item->id }}">
                    {{ $item->name }} – Rp {{ number_format($item->price_per_day, 0, ',', '.') }}/hari
                  </option>
                @endforeach
              </select>
              <input type="number" name="quantities[]" class="form-control" value="1" min="1" style="flex:1;" placeholder="Qty">
            </div>
          </div>
          <button type="button" class="btn-orange-text fs-13 mt-4" onclick="addItemRow()">
            + Tambah Item
          </button>
        </div>
      </div>
      <div class="modal-foot">
        <button type="button" class="btn" style="background:#f0ede6;color:#555;" onclick="closeModal('create-modal')">Batal</button>
        <button type="submit" class="btn btn-success">Simpan Booking</button>
      </div>
    </form>
  </div>
</div>

@endsection

@section('scripts')
<script>
  // Build item row HTML
  const allItems = @json($items->map(fn($i) => ['id'=>$i->id,'name'=>$i->name,'price'=>$i->price_per_day]));

  function buildItemOptions() {
    return allItems.map(i =>
      `<option value="${i.id}">${i.name} – Rp ${parseInt(i.price).toLocaleString('id-ID')}/hari</option>`
    ).join('');
  }

  function addItemRow() {
    const row = document.createElement('div');
    row.className = 'item-entry';
    row.style = 'display:flex;gap:8px;margin-bottom:8px;align-items:center;';
    row.innerHTML = `
      <select name="item_ids[]" class="form-control" style="flex:3;">
        <option value="">Pilih Barang</option>
        ${buildItemOptions()}
      </select>
      <input type="number" name="quantities[]" class="form-control" value="1" min="1" style="flex:1;">
      <button type="button" onclick="this.parentElement.remove()"
              style="background:none;border:none;cursor:pointer;color:#e53935;font-size:18px;">
        <i class="fa-solid fa-circle-minus"></i>
      </button>`;
    document.getElementById('item-list').appendChild(row);
  }

  function openCreateModal() {
    document.getElementById('create-modal').classList.add('show');
  }

  function closeModal(id) {
    document.getElementById(id).classList.remove('show');
  }

  document.querySelectorAll('.modal-backdrop').forEach(el => {
    el.addEventListener('click', e => { if (e.target === el) el.classList.remove('show'); });
  });
</script>
@endsection
