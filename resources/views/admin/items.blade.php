@extends('layouts.admin')

@section('title', 'Data Barang')
@section('page-title', 'Data Barang')

@section('content')

<div class="page-header" style="margin-bottom: 0.5rem;">
  <div>
    <h2 style="font-size: 1.6rem; font-weight: 800; color: #1F2E26; font-family: 'Outfit', sans-serif;">Data Barang</h2>
    <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 0.15rem;">Kelola semua barang yang tersedia untuk disewakan</p>
  </div>
  <button class="btn btn-success" style="background-color: #0C2D1C; color: #FFFFFF; font-weight: 600; padding: 0.6rem 1.2rem; border-radius: 8px; font-size: 0.9rem;" onclick="openAddModal()">
    + Tambah Barang
  </button>
</div>

{{-- Filters & Search Row --}}
<form method="GET" action="{{ route('admin.items.index') }}" id="filter-form" style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1rem; margin-top: 1.5rem; margin-bottom: 1.5rem; background: #FFF; padding: 1rem 1.25rem; border-radius: 12px; border: 1px solid #ECE7DD;">
  <div class="topbar-search" style="max-width: 320px; margin-bottom: 0; padding: 0;">
    <i class="fa-solid fa-magnifying-glass" style="left: 1rem; color: #A0B0A8;"></i>
    <input type="text" name="search" placeholder="Cari barang..." value="{{ request('search') }}" style="padding: 10px 14px 10px 2.5rem; font-size: 0.85rem; border: none; background: transparent; width: 100%;" onchange="this.form.submit()">
  </div>
  
  <div style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
    <select name="category" onchange="this.form.submit()" style="padding: 9px 14px; border: 1px solid #ECE7DD; border-radius: 8px; font-size: 0.85rem; background: #FFF; outline: none; color: #1F2E26; font-weight: 500; font-family: inherit; cursor: pointer;">
      <option value="">Semua Kategori</option>
      <option value="Aksesoris Hiking & Camping" {{ request('category') == 'Aksesoris Hiking & Camping' ? 'selected' : '' }}>Aksesoris Hiking & Camping</option>
      <option value="Carrier 50L - 100L" {{ request('category') == 'Carrier 50L - 100L' ? 'selected' : '' }}>Carrier 50L - 100L</option>
      <option value="Celana Outdoor" {{ request('category') == 'Celana Outdoor' ? 'selected' : '' }}>Celana Outdoor</option>
      <option value="Daypack 15L - 30L" {{ request('category') == 'Daypack 15L - 30L' ? 'selected' : '' }}>Daypack 15L - 30L</option>
      <option value="Flysheet & Jas Hujan & Tiang" {{ request('category') == 'Flysheet & Jas Hujan & Tiang' ? 'selected' : '' }}>Flysheet & Jas Hujan & Tiang</option>
      <option value="Hydropack/Vest/Trailrun" {{ request('category') == 'Hydropack/Vest/Trailrun' ? 'selected' : '' }}>Hydropack/Vest/Trailrun</option>
      <option value="Jaket Gunung" {{ request('category') == 'Jaket Gunung' ? 'selected' : '' }}>Jaket Gunung</option>
      <option value="Jaket Midlayer" {{ request('category') == 'Jaket Midlayer' ? 'selected' : '' }}>Jaket Midlayer</option>
      <option value="Jaket Outer Layer" {{ request('category') == 'Jaket Outer Layer' ? 'selected' : '' }}>Jaket Outer Layer</option>
      <option value="Jaket Puffer / Down" {{ request('category') == 'Jaket Puffer / Down' ? 'selected' : '' }}>Jaket Puffer / Down</option>
      <option value="Kamera & Drone & Mic" {{ request('category') == 'Kamera & Drone & Mic' ? 'selected' : '' }}>Kamera & Drone & Mic</option>
      <option value="Koper Traveling" {{ request('category') == 'Koper Traveling' ? 'selected' : '' }}>Koper Traveling</option>
      <option value="Lampu & Senter Kepala" {{ request('category') == 'Lampu & Senter Kepala' ? 'selected' : '' }}>Lampu & Senter Kepala</option>
      <option value="Meja & Kursi" {{ request('category') == 'Meja & Kursi' ? 'selected' : '' }}>Meja & Kursi</option>
      <option value="Perlengkapan Masak & Alat Makan" {{ request('category') == 'Perlengkapan Masak & Alat Makan' ? 'selected' : '' }}>Perlengkapan Masak & Alat Makan</option>
      <option value="Power Bank & Kabel" {{ request('category') == 'Power Bank & Kabel' ? 'selected' : '' }}>Power Bank & Kabel</option>
      <option value="Semi Carrier 35L - 45L" {{ request('category') == 'Semi Carrier 35L - 45L' ? 'selected' : '' }}>Semi Carrier 35L - 45L</option>
      <option value="Sepatu & Sandal Trekking" {{ request('category') == 'Sepatu & Sandal Trekking' ? 'selected' : '' }}>Sepatu & Sandal Trekking</option>
      <option value="Sleeping Bag & Matras" {{ request('category') == 'Sleeping Bag & Matras' ? 'selected' : '' }}>Sleeping Bag & Matras</option>
      <option value="Tenda 2-3 Orang" {{ request('category') == 'Tenda 2-3 Orang' ? 'selected' : '' }}>Tenda 2-3 Orang</option>
      <option value="Tenda 4 Orang" {{ request('category') == 'Tenda 4 Orang' ? 'selected' : '' }}>Tenda 4 Orang</option>
      <option value="Tenda 6 Orang" {{ request('category') == 'Tenda 6 Orang' ? 'selected' : '' }}>Tenda 6 Orang</option>
      <option value="Trekking Pole" {{ request('category') == 'Trekking Pole' ? 'selected' : '' }}>Trekking Pole</option>
      <option value="Paket Hiking" {{ request('category') == 'Paket Hiking' ? 'selected' : '' }}>Paket Hiking</option>
      <option value="Paket Camping" {{ request('category') == 'Paket Camping' ? 'selected' : '' }}>Paket Camping</option>
    </select>
    
    <select name="status" onchange="this.form.submit()" style="padding: 9px 14px; border: 1px solid #ECE7DD; border-radius: 8px; font-size: 0.85rem; background: #FFF; outline: none; color: #1F2E26; font-weight: 500; font-family: inherit; cursor: pointer;">
      <option value="">Semua Status</option>
      <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
      <option value="habis" {{ request('status') == 'habis' ? 'selected' : '' }}>Habis</option>
    </select>

    <!-- Grid / List view toggle buttons (visual indicator matching mockup) -->
    <div style="display: flex; gap: 0.25rem;">
      <button type="button" style="padding: 8px 10px; border: 1px solid #ECE7DD; background: #FFF; border-radius: 6px; cursor: pointer; color: #A0B0A8; font-size: 0.9rem;"><i class="fa-solid fa-grip"></i></button>
      <button type="button" style="padding: 8px 10px; border: 1px solid #ECE7DD; background: #FAF6EC; border-radius: 6px; cursor: pointer; color: #0C2D1C; font-size: 0.9rem;"><i class="fa-solid fa-list"></i></button>
    </div>
  </div>
</form>

{{-- Table view for Data Barang --}}
<div class="table-responsive-admin" style="background: #FFF; border-radius: 12px; border: 1px solid #ECE7DD; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
  <table class="table-admin" style="width: 100%; border-collapse: collapse;">
    <thead>
      <tr>
        <th style="width: 35%;">Barang</th>
        <th style="width: 15%;">Kategori</th>
        <th style="width: 15%;">Harga / Hari</th>
        <th style="width: 10%;">Stok</th>
        <th style="width: 15%;">Status</th>
        <th style="width: 10%; text-align: center;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($items as $item)
        <tr>
          <td>
            <div style="display: flex; align-items: center; gap: 1rem;">
              <div class="item-thumb-sm" style="width: 50px; height: 50px; border-radius: 8px; border: 1px solid #ECE7DD; background: #FAF6EC; display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0;">
                @if($item->image)
                  <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                  <span style="font-size: 1.5rem;">
                    @if(str_contains(strtolower($item->category), 'tenda'))
                      ⛺
                    @elseif(str_contains(strtolower($item->category), 'tas'))
                      🎒
                    @elseif(str_contains(strtolower($item->category), 'masak'))
                      🍳
                    @else
                      🏕️
                    @endif
                  </span>
                @endif
              </div>
              <span style="font-weight: 600; color: #1F2E26; font-size: 0.95rem;">{{ $item->name }}</span>
            </div>
          </td>
          <td style="color: var(--text-muted); font-size: 0.9rem;">{{ $item->category }}</td>
          <td style="font-weight: 600; color: #1F2E26; font-size: 0.9rem;">Rp {{ number_format($item->price_per_day, 0, ',', '.') }}</td>
          <td>
            <button type="button" style="background: none; border: none; padding: 0; cursor: pointer; font-family: inherit; font-weight: 600; color: #1F2E26; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 0.35rem;"
                    onclick="openStokModal({{ $item->id }}, '{{ addslashes($item->name) }}', {{ $item->stock }})"
                    title="Klik untuk update stok">
              {{ $item->stock }}
              <i class="fa-solid fa-pen-to-square" style="font-size: 0.75rem; color: var(--text-muted); opacity: 0.6;"></i>
            </button>
          </td>
          <td>
            @if($item->stock > 0)
              <span class="badge-status status-tersedia">Tersedia</span>
            @else
              <span class="badge-status status-habis">Habis</span>
            @endif
          </td>
          <td>
            <div style="display: flex; gap: 0.5rem; justify-content: center; align-items: center;">
              <button class="btn-action-edit" onclick="openEditModal({{ json_encode($item) }})" title="Ubah data">
                <i class="fa-solid fa-pen"></i>
              </button>
              
              <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST"
                    onsubmit="return confirm('Hapus barang ini? Semua booking terkait juga akan terhapus.')"
                    style="display: inline-block; margin: 0;">
                @csrf @method('DELETE')
                <button type="submit" class="btn-action-delete" title="Hapus">
                  <i class="fa-solid fa-trash-can"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" style="padding: 3rem; text-align: center;">
            <div class="empty-state">
              <i class="fa-solid fa-box-open" style="font-size: 2.5rem; color: var(--text-muted); margin-bottom: 0.75rem;"></i>
              <p style="color: var(--text-muted); font-size: 0.95rem;">Belum ada data barang tersedia.</p>
            </div>
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

{{-- Pagination Footer matching mockup --}}
<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem; background: #FFF; padding: 0.9rem 1.5rem; border-radius: 12px; border: 1px solid #ECE7DD;">
  <span style="font-size: 0.85rem; color: var(--text-muted);">
    Menampilkan 1 - {{ $items->count() }} dari {{ $items->count() }} data
  </span>
  <div style="display: flex; gap: 0.25rem; align-items: center;">
    <button type="button" style="padding: 6px 12px; border: 1px solid #ECE7DD; background: #FFF; border-radius: 6px; cursor: pointer; color: #6B7C73; font-size: 0.85rem;"><i class="fa-solid fa-chevron-left"></i></button>
    <button type="button" style="padding: 6px 12px; border: none; background: #0C2D1C; color: #FFF; border-radius: 6px; cursor: pointer; font-size: 0.85rem; font-weight: 700;">1</button>
    <button type="button" style="padding: 6px 12px; border: 1px solid #ECE7DD; background: #FFF; border-radius: 6px; cursor: pointer; color: #6B7C73; font-size: 0.85rem;"><i class="fa-solid fa-chevron-right"></i></button>
  </div>
</div>


{{-- ── Modal Tambah Barang ─────────────────────────── --}}
<div class="modal-backdrop" id="add-modal">
  <div class="modal-box modal-box-wide" style="padding: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid #ECE7DD; padding-bottom: 1rem;">
      <div>
        <h3 style="font-size: 1.4rem; font-weight: 700; color: #1F2E26; font-family: 'Outfit', sans-serif;">Tambah Barang</h3>
        <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.15rem;">Tambah barang baru ke dalam sistem</p>
      </div>
      <button onclick="closeModal('add-modal')" style="background: none; border: none; font-size: 1.5rem; color: #A0B0A8; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; height: 32px; width: 32px; border-radius: 50%; hover: {background: #FAF6EC}">&times;</button>
    </div>
    
    <form action="{{ route('admin.items.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="form-split-grid">
        <!-- Left Column -->
        <div>
          <div class="form-group">
            <label class="form-label">Nama Barang</label>
            <input type="text" name="name" class="form-control" placeholder="Masukkan nama barang" style="padding: 11px 14px; border: 1px solid #ECE7DD; border-radius: 8px;" required>
          </div>
          
          <div class="form-group">
            <label class="form-label">Kategori</label>
            <select name="category" class="form-control" style="padding: 11px 14px; border: 1px solid #ECE7DD; border-radius: 8px; cursor: pointer;" required>
              <option value="">Pilih kategori</option>
              <option value="Aksesoris Hiking & Camping">Aksesoris Hiking & Camping</option>
              <option value="Carrier 50L - 100L">Carrier 50L - 100L</option>
              <option value="Celana Outdoor">Celana Outdoor</option>
              <option value="Daypack 15L - 30L">Daypack 15L - 30L</option>
              <option value="Flysheet & Jas Hujan & Tiang">Flysheet & Jas Hujan & Tiang</option>
              <option value="Hydropack/Vest/Trailrun">Hydropack/Vest/Trailrun</option>
              <option value="Jaket Gunung">Jaket Gunung</option>
              <option value="Jaket Midlayer">Jaket Midlayer</option>
              <option value="Jaket Outer Layer">Jaket Outer Layer</option>
              <option value="Jaket Puffer / Down">Jaket Puffer / Down</option>
              <option value="Kamera & Drone & Mic">Kamera & Drone & Mic</option>
              <option value="Koper Traveling">Koper Traveling</option>
              <option value="Lampu & Senter Kepala">Lampu & Senter Kepala</option>
              <option value="Meja & Kursi">Meja & Kursi</option>
              <option value="Perlengkapan Masak & Alat Makan">Perlengkapan Masak & Alat Makan</option>
              <option value="Power Bank & Kabel">Power Bank & Kabel</option>
              <option value="Semi Carrier 35L - 45L">Semi Carrier 35L - 45L</option>
              <option value="Sepatu & Sandal Trekking">Sepatu & Sandal Trekking</option>
              <option value="Sleeping Bag & Matras">Sleeping Bag & Matras</option>
              <option value="Tenda 2-3 Orang">Tenda 2-3 Orang</option>
              <option value="Tenda 4 Orang">Tenda 4 Orang</option>
              <option value="Tenda 6 Orang">Tenda 6 Orang</option>
              <option value="Trekking Pole">Trekking Pole</option>
              <option value="Paket Hiking">Paket Hiking</option>
              <option value="Paket Camping">Paket Camping</option>
            </select>
          </div>
          
          <div class="form-group">
            <label class="form-label">Harga Sewa / Hari</label>
            <div style="position: relative;">
              <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); font-weight: 600; color: var(--text-muted); font-size: 0.9rem;">Rp</span>
              <input type="number" name="price_per_day" class="form-control" min="0" placeholder="Masukkan harga sewa" style="padding: 11px 14px 11px 2.5rem; border: 1px solid #ECE7DD; border-radius: 8px;" required>
            </div>
          </div>
          
          <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" placeholder="Masukkan deskripsi barang" class="form-control" style="height: 100px; resize: none; border: 1px solid #ECE7DD; border-radius: 8px; font-family: inherit; padding: 11px 14px;"></textarea>
          </div>
        </div>
        
        <!-- Right Column -->
        <div style="display: flex; flex-direction: column; justify-content: space-between;">
          <div class="form-group">
            <label class="form-label">Stok</label>
            <input type="number" name="stock" class="form-control" min="0" placeholder="Masukkan jumlah stok" style="padding: 11px 14px; border: 1px solid #ECE7DD; border-radius: 8px;" required>
          </div>
          
          <div class="form-group">
            <label class="form-label">Gambar Barang</label>
            <div class="upload-container" onclick="document.getElementById('add-image-input').click()" style="min-height: 166px;">
              <i class="fa-solid fa-cloud-arrow-up upload-icon"></i>
              <span class="upload-text" id="add-upload-text" style="font-size: 0.85rem;">Klik untuk upload gambar</span>
              <span class="upload-subtext" style="font-size: 0.7rem;">PNG, JPG maks. 2MB</span>
              <input type="file" name="image" id="add-image-input" accept="image/*" style="display: none;" onchange="handleFileSelect(this, 'add-upload-text')">
            </div>
          </div>
          
          <div style="display: flex; gap: 0.75rem; justify-content: flex-end; margin-top: 1.5rem;">
            <button type="button" class="btn" style="background:#FFF; border:1px solid #ECE7DD; color:#1F2E26; font-weight:600; border-radius:8px; padding: 10px 20px;" onclick="closeModal('add-modal')">Batal</button>
            <button type="submit" class="btn" style="background:#0C2D1C; color:#FFF; font-weight:600; border-radius:8px; padding: 10px 20px; display:inline-flex; align-items:center; gap:0.35rem;">
              Simpan Barang
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

{{-- ── Modal Edit Barang ────────────────────────────── --}}
<div class="modal-backdrop" id="edit-modal">
  <div class="modal-box modal-box-wide" style="padding: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid #ECE7DD; padding-bottom: 1rem;">
      <div>
        <h3 style="font-size: 1.4rem; font-weight: 700; color: #1F2E26; font-family: 'Outfit', sans-serif;">Ubah Data Barang</h3>
        <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.15rem;">Ubah rincian barang dalam sistem</p>
      </div>
      <button onclick="closeModal('edit-modal')" style="background: none; border: none; font-size: 1.5rem; color: #A0B0A8; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; height: 32px; width: 32px; border-radius: 50%;">&times;</button>
    </div>
    
    <form id="edit-form" method="POST" enctype="multipart/form-data">
      @csrf @method('PUT')
      <div class="form-split-grid">
        <!-- Left Column -->
        <div>
          <div class="form-group">
            <label class="form-label">Nama Barang</label>
            <input type="text" name="name" id="edit-name" class="form-control" placeholder="Masukkan nama barang" style="padding: 11px 14px; border: 1px solid #ECE7DD; border-radius: 8px;" required>
          </div>
          
          <div class="form-group">
            <label class="form-label">Kategori</label>
            <select name="category" id="edit-category" class="form-control" style="padding: 11px 14px; border: 1px solid #ECE7DD; border-radius: 8px; cursor: pointer;" required>
              <option value="Aksesoris Hiking & Camping">Aksesoris Hiking & Camping</option>
              <option value="Carrier 50L - 100L">Carrier 50L - 100L</option>
              <option value="Celana Outdoor">Celana Outdoor</option>
              <option value="Daypack 15L - 30L">Daypack 15L - 30L</option>
              <option value="Flysheet & Jas Hujan & Tiang">Flysheet & Jas Hujan & Tiang</option>
              <option value="Hydropack/Vest/Trailrun">Hydropack/Vest/Trailrun</option>
              <option value="Jaket Gunung">Jaket Gunung</option>
              <option value="Jaket Midlayer">Jaket Midlayer</option>
              <option value="Jaket Outer Layer">Jaket Outer Layer</option>
              <option value="Jaket Puffer / Down">Jaket Puffer / Down</option>
              <option value="Kamera & Drone & Mic">Kamera & Drone & Mic</option>
              <option value="Koper Traveling">Koper Traveling</option>
              <option value="Lampu & Senter Kepala">Lampu & Senter Kepala</option>
              <option value="Meja & Kursi">Meja & Kursi</option>
              <option value="Perlengkapan Masak & Alat Makan">Perlengkapan Masak & Alat Makan</option>
              <option value="Power Bank & Kabel">Power Bank & Kabel</option>
              <option value="Semi Carrier 35L - 45L">Semi Carrier 35L - 45L</option>
              <option value="Sepatu & Sandal Trekking">Sepatu & Sandal Trekking</option>
              <option value="Sleeping Bag & Matras">Sleeping Bag & Matras</option>
              <option value="Tenda 2-3 Orang">Tenda 2-3 Orang</option>
              <option value="Tenda 4 Orang">Tenda 4 Orang</option>
              <option value="Tenda 6 Orang">Tenda 6 Orang</option>
              <option value="Trekking Pole">Trekking Pole</option>
              <option value="Paket Hiking">Paket Hiking</option>
              <option value="Paket Camping">Paket Camping</option>
            </select>
          </div>
          
          <div class="form-group">
            <label class="form-label">Harga Sewa / Hari</label>
            <div style="position: relative;">
              <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); font-weight: 600; color: var(--text-muted); font-size: 0.9rem;">Rp</span>
              <input type="number" name="price_per_day" id="edit-price" class="form-control" min="0" placeholder="Masukkan harga sewa" style="padding: 11px 14px 11px 2.5rem; border: 1px solid #ECE7DD; border-radius: 8px;" required>
            </div>
          </div>
          
          <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" id="edit-description" placeholder="Masukkan deskripsi barang" class="form-control" style="height: 100px; resize: none; border: 1px solid #ECE7DD; border-radius: 8px; font-family: inherit; padding: 11px 14px;"></textarea>
          </div>
        </div>
        
        <!-- Right Column -->
        <div style="display: flex; flex-direction: column; justify-content: space-between;">
          <div class="form-group">
            <label class="form-label">Stok</label>
            <input type="number" name="stock" id="edit-stock" class="form-control" min="0" placeholder="Masukkan jumlah stok" style="padding: 11px 14px; border: 1px solid #ECE7DD; border-radius: 8px;" required>
          </div>
          
          <div class="form-group">
            <label class="form-label">Ganti Foto Barang (opsional)</label>
            <div class="upload-container" onclick="document.getElementById('edit-image-input').click()" style="min-height: 166px;">
              <i class="fa-solid fa-cloud-arrow-up upload-icon"></i>
              <span class="upload-text" id="edit-upload-text" style="font-size: 0.85rem;">Klik untuk upload gambar</span>
              <span class="upload-subtext" style="font-size: 0.7rem;">PNG, JPG maks. 2MB</span>
              <input type="file" name="image" id="edit-image-input" accept="image/*" style="display: none;" onchange="handleFileSelect(this, 'edit-upload-text')">
            </div>
          </div>
          
          <div style="display: flex; gap: 0.75rem; justify-content: flex-end; margin-top: 1.5rem;">
            <button type="button" class="btn" style="background:#FFF; border:1px solid #ECE7DD; color:#1F2E26; font-weight:600; border-radius:8px; padding: 10px 20px;" onclick="closeModal('edit-modal')">Batal</button>
            <button type="submit" class="btn" style="background:#0C2D1C; color:#FFF; font-weight:600; border-radius:8px; padding: 10px 20px; display:inline-flex; align-items:center; gap:0.35rem;">
              Simpan Barang
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

{{-- ── Popup Update Stok ───────────────────────────── --}}
<div class="popup-overlay" id="popup-stok">
  <div class="stok-popup-card">
    <h3 class="stok-popup-title" style="font-family: 'Outfit', sans-serif;">Update Stok</h3>

    <div class="stok-popup-item">
      <div id="stok-item-name" class="stok-item-name">Nama Barang</div>
      <div id="stok-item-current" class="stok-item-current">Stok saat ini : 0</div>
    </div>

    <form id="stok-form" method="POST">
      @csrf @method('PATCH')
      <div class="stok-input-group">
        <label class="stok-label">Stok Baru</label>
        <input type="number" name="stock" id="stok-input"
               class="stok-input" min="0" value="0" required>
      </div>
      <button type="submit" class="stok-save-btn" style="background-color: #0C2D1C;">Simpan</button>
    </form>
  </div>
</div>

@endsection

@section('scripts')
<style>
  /* ── Update Stok Popup Card ──────────────────────── */
  .stok-popup-card {
    background: #f5f0e4;
    border-radius: 18px;
    padding: 28px 24px 24px;
    width: 100%;
    max-width: 340px;
    box-shadow: 0 16px 48px rgba(0,0,0,0.22);
    transform: scale(0.92) translateY(12px);
    transition: transform .28s cubic-bezier(0.34, 1.56, 0.64, 1);
  }

  .popup-overlay.show .stok-popup-card {
    transform: scale(1) translateY(0);
  }

  .stok-popup-title {
    font-size: 20px;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 20px;
  }

  .stok-popup-item {
    margin-bottom: 20px;
  }

  .stok-item-name {
    font-size: 15px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 4px;
  }

  .stok-item-current {
    font-size: 13px;
    color: var(--text-muted);
  }

  .stok-input-group {
    margin-bottom: 18px;
  }

  .stok-label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 8px;
  }

  .stok-input {
    width: 100%;
    padding: 12px 16px;
    font-size: 16px;
    font-weight: 600;
    border: 1.5px solid #ddd;
    border-radius: 10px;
    background: #fff;
    color: #1a1a1a;
    transition: border-color .2s;
    font-family: inherit;
  }

  .stok-input:focus {
    border-color: var(--accent);
    outline: none;
  }

  .stok-save-btn {
    width: 100%;
    padding: 14px;
    background: var(--accent);
    color: #fff;
    font-size: 15px;
    font-weight: 700;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-family: inherit;
    transition: background .2s, transform .1s;
  }

  .stok-save-btn:hover   { background: var(--accent-hover); }
  .stok-save-btn:active  { transform: scale(0.98); }
</style>

<script>
  /* ── Item CRUD Modals ──────────────────────── */
  function openAddModal() {
    // Reset file input label
    document.getElementById('add-upload-text').textContent = 'Klik untuk upload gambar';
    document.getElementById('add-upload-text').style.color = '#1F2E26';
    document.getElementById('add-modal').classList.add('show');
  }

  function openEditModal(item) {
    // Reset file input label
    document.getElementById('edit-upload-text').textContent = 'Klik untuk upload gambar';
    document.getElementById('edit-upload-text').style.color = '#1F2E26';
    
    const form = document.getElementById('edit-form');
    form.action = `/admin/items/${item.id}`;
    document.getElementById('edit-name').value     = item.name;
    document.getElementById('edit-category').value = item.category;
    document.getElementById('edit-stock').value    = item.stock;
    document.getElementById('edit-price').value    = Math.round(item.price_per_day);
    document.getElementById('edit-description').value = item.description || '';
    document.getElementById('edit-modal').classList.add('show');
  }

  function closeModal(id) {
    document.getElementById(id).classList.remove('show');
  }

  function handleFileSelect(input, textId) {
    const textEl = document.getElementById(textId);
    if (input.files && input.files[0]) {
      textEl.textContent = input.files[0].name;
      textEl.style.color = '#10B981';
    } else {
      textEl.textContent = 'Klik untuk upload gambar';
      textEl.style.color = '#1F2E26';
    }
  }

  /* ── Update Stok Popup ─────────────────────── */
  function openStokModal(itemId, itemName, currentStock) {
    document.getElementById('stok-item-name').textContent    = itemName;
    document.getElementById('stok-item-current').textContent = 'Stok saat ini : ' + currentStock;
    document.getElementById('stok-input').value              = currentStock;
    document.getElementById('stok-form').action              = `/admin/items/${itemId}/stock`;
    document.getElementById('popup-stok').classList.add('show');
    document.body.style.overflow = 'hidden';
    setTimeout(() => {
      const inp = document.getElementById('stok-input');
      inp.focus();
      inp.select();
    }, 280);
  }

  function closeStokPopup() {
    document.getElementById('popup-stok').classList.remove('show');
    document.body.style.overflow = '';
  }

  // Close modal-backdrop on overlay click
  document.querySelectorAll('.modal-backdrop').forEach(el => {
    el.addEventListener('click', e => {
      if (e.target === el) el.classList.remove('show');
    });
  });

  // Close stok popup on overlay click
  document.getElementById('popup-stok').addEventListener('click', function(e) {
    if (e.target === this) closeStokPopup();
  });

  // Escape key closes everything
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      document.querySelectorAll('.modal-backdrop').forEach(el => el.classList.remove('show'));
      closeStokPopup();
    }
  });
</script>
@endsection
