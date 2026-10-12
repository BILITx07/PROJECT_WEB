@extends('layouts.user')
@section('title', 'Wishlist Saya')

@section('content')
<div class="page-container" style="padding-top:100px; padding-bottom:100px;">
  <div class="section-title">
    <h2 class="title" style="font-size: 2.2rem; font-weight: 800; color: var(--text-dark); margin-bottom: 0.5rem; line-height: 1.2;">Favorit <span class="text-orange">Saya</span></h2>
    <p class="subtitle" style="font-size: 1rem; color: var(--text-muted);">Daftar barang yang Anda simpan untuk nanti.</p>
  </div>

  @if($wishlists->count() > 0)
    <div class="product-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 30px; margin-top: 30px;">
      @foreach($wishlists as $wishlist)
        @php
          $item = $wishlist->item;
        @endphp
        <div class="product-card" style="background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.04); transition:all 0.3s ease;">
          <div class="product-image-wrapper" style="position:relative; aspect-ratio:4/3;">
            @if($item->image)
              <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="product-image" style="width:100%; height:100%; object-fit:cover;">
            @else
              <img src="https://via.placeholder.com/300x200?text=No+Image" alt="No Image" class="product-image" style="width:100%; height:100%; object-fit:cover;">
            @endif
            
            <!-- Tombol Hati (Sudah Aktif) -->
            <button type="button" class="wishlist-btn active" data-id="{{ $item->id }}" 
                    style="position: absolute; top: 12px; right: 12px; width: 36px; height: 36px; border-radius: 50%; background: white; border: none; box-shadow: 0 4px 10px rgba(0,0,0,0.1); cursor: pointer; display: flex; align-items: center; justify-content: center; z-index: 10; transition: all 0.3s ease;">
              <i class="fa-solid fa-heart" style="color: #ff4757; font-size: 18px; transition: transform 0.2s;"></i>
            </button>
          </div>
          <div class="product-info" style="padding: 20px;">
            <h3 class="product-title" style="font-size:1.15rem; font-weight:700; margin-bottom:10px; color:var(--text-dark);">{{ $item->name }}</h3>
            <div class="product-price" style="font-size:1.1rem; font-weight:800; color:var(--accent-orange); margin-bottom:12px;">
                Rp {{ number_format($item->price_per_day, 0, ',', '.') }}<span style="font-size: 0.85rem; color: #7f8c8d; font-weight: 400;"> / hari</span>
            </div>
            <p class="product-stock {{ $item->stock > 0 ? 'text-green' : 'text-red' }}" style="font-size:13px; font-weight:600; margin-bottom:15px; color: {{ $item->stock > 0 ? '#27ae60' : '#e74c3c' }};">
              <i class="fa-solid {{ $item->stock > 0 ? 'fa-check-circle' : 'fa-xmark-circle' }}"></i>
              {{ $item->stock > 0 ? 'Stok Tersedia: ' . $item->stock : 'Stok Habis' }}
            </p>
            <form action="{{ route('user.cart.add') }}" method="POST">
              @csrf
              <input type="hidden" name="item_id" value="{{ $item->id }}">
              <button type="submit" class="btn btn-primary" style="width: 100%; border-radius: 8px; padding: 10px; background:var(--accent-orange); border:none; color:white; font-weight:700;" {{ $item->stock < 1 ? 'disabled' : '' }}>
                <i class="fa-solid fa-cart-plus"></i> Masukkan Keranjang
              </button>
            </form>
          </div>
        </div>
      @endforeach
    </div>
  @else
    <div style="text-align: center; padding: 80px 20px; background: #fff; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); margin-top: 30px;">
      <i class="fa-regular fa-heart" style="font-size: 80px; color: #ffd6d6; margin-bottom: 20px;"></i>
      <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--text-dark); margin-bottom: 10px;">Wishlist Anda masih kosong</h3>
      <p style="color: var(--text-muted); margin-bottom: 30px; font-size: 1rem;">Sepertinya Anda belum menemukan barang yang Anda sukai.</p>
      <a href="{{ route('user.dashboard') }}" class="btn btn-primary" style="padding: 12px 30px; border-radius: 50px; background:var(--accent-orange); border:none; color:white; text-decoration:none; display:inline-block; font-weight:600;">
        <i class="fa-solid fa-compass" style="margin-right: 8px;"></i> Mulai Eksplorasi
      </a>
    </div>
  @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tangani interaksi tombol wishlist
    const wishlistBtns = document.querySelectorAll('.wishlist-btn');
    
    wishlistBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const itemId = this.getAttribute('data-id');
            const icon = this.querySelector('i');
            const card = this.closest('.product-card');
            
            // Tampilkan animasi denyut (pulse)
            icon.style.transform = 'scale(1.3)';
            setTimeout(() => { icon.style.transform = 'scale(1)'; }, 200);

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
                if (data.status === 'removed') {
                    // Beri efek transisi lenyap
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.9)';
                    setTimeout(() => {
                        card.remove();
                        // Refresh halaman jika wishlist habis
                        if (document.querySelectorAll('.product-card').length === 0) {
                            window.location.reload();
                        }
                    }, 400);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan koneksi.');
            });
        });
    });
});
</script>
@endsection
