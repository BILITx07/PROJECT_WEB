@extends('layouts.user')

@section('title', 'Keranjang Belanja - CampRent')

@section('content')
<h2 style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
    <i class="fa-solid fa-shopping-cart" style="color: var(--forest-green);"></i> Keranjang Belanja
</h2>

@if ($cartItems->isEmpty())
    <div class="empty-state">
        <i class="fa-solid fa-basket-shopping fa-3x" style="color: var(--text-muted); margin-bottom: 1rem; display:block;"></i>
        <h3>Keranjang Anda Kosong</h3>
        <p style="margin-bottom: 1.5rem;">Anda belum menambahkan barang ke keranjang.</p>
        <a href="{{ route('user.dashboard') }}" class="btn-checkout" style="display:inline-block; width:auto; padding: 0.75rem 2rem;">Mulai Belanja</a>
    </div>
@else
    <div class="cart-layout">
        <!-- List of Items -->
        <div class="cart-items-card">
            @foreach ($cartItems as $cartItem)
                <div class="cart-item-row">
                    <div class="cart-item-thumb">
                        @if ($cartItem->item->image)
                            <img src="{{ asset('storage/' . $cartItem->item->image) }}" alt="{{ $cartItem->item->name }}">
                        @else
                            <i class="fa-solid fa-tents fa-2x" style="color: var(--light-gray);"></i>
                        @endif
                    </div>
                    
                    <div class="cart-item-info">
                        <h4 class="cart-item-name">{{ $cartItem->item->name }}</h4>
                        <span class="cart-item-category">{{ $cartItem->item->category }}</span>
                        <span class="cart-item-price">Rp {{ number_format($cartItem->item->price_per_day, 0, ',', '.') }} <span style="font-weight:400; font-size: 0.8rem; color: var(--text-muted);">/ hari</span></span>
                    </div>

                    <div class="cart-item-controls">
                        <!-- Qty Spinner Controls -->
                        <div class="qty-spinner">
                            <form action="{{ route('user.cart.update', $cartItem->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="action" value="decrease">
                                <button type="submit" class="qty-btn">-</button>
                            </form>
                            <span class="qty-val">{{ $cartItem->quantity }}</span>
                            <form action="{{ route('user.cart.update', $cartItem->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="action" value="increase">
                                <button type="submit" class="qty-btn">+</button>
                            </form>
                        </div>

                        <!-- Remove Action (Circle Red Trash Button) -->
                        <form action="{{ route('user.cart.remove', $cartItem->id) }}" method="POST" style="margin-top: 0.5rem;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-remove-cart" title="Hapus Barang">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Summary & Dates -->
        <div class="cart-summary-card">
            <h3 class="summary-title" style="font-size: 1.15rem; font-weight: 700; margin-bottom: 1.25rem;">Ringkasan Sewa</h3>
            
            <!-- Rental Date Form -->
            <form action="{{ route('user.cart.dates') }}" method="POST" class="summary-date-picker" style="background: none; border: none; padding: 0; margin-bottom: 1.5rem;">
                @csrf
                <div class="form-group" style="margin-bottom: 1.25rem; display: flex; flex-direction: column; gap: 0.4rem;">
                    <label for="cart_start_date" style="font-size: 0.85rem; font-weight: 600; color: var(--text-dark);">Tanggal Pinjam</label>
                    <div style="position: relative;">
                        <input type="date" name="start_date" id="cart_start_date" class="form-input" style="border: 1px solid #ECE7DD; border-radius: 8px; padding: 0.75rem 1rem; width: 100%; outline: none;" value="{{ $startDate }}" min="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="form-group" style="margin-bottom: 1.25rem; display: flex; flex-direction: column; gap: 0.4rem;">
                    <label for="cart_end_date" style="font-size: 0.85rem; font-weight: 600; color: var(--text-dark);">Tanggal Kembali</label>
                    <div style="position: relative;">
                        <input type="date" name="end_date" id="cart_end_date" class="form-input" style="border: 1px solid #ECE7DD; border-radius: 8px; padding: 0.75rem 1rem; width: 100%; outline: none;" value="{{ $endDate }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                    </div>
                </div>
                <button type="submit" class="btn-check-availability" style="width: 100%; padding: 0.75rem; font-size: 0.9rem; border-radius: 8px; background-color: var(--forest-green); border: none; color: white; cursor: pointer; transition: background-color 0.2s;">
                    Update Periode
                </button>
            </form>

            <div class="summary-row" style="margin-bottom: 0.65rem;">
                <span>Durasi Sewa:</span>
                <span style="font-weight: 600;">{{ $duration }} hari</span>
            </div>

            <div class="summary-row" style="margin-bottom: 0.65rem;">
                <span>Subtotal:</span>
                <span style="font-weight: 600;">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
            </div>

            <div class="summary-row" style="margin-bottom: 1.25rem;">
                <span>Biaya Layanan:</span>
                <span style="font-weight: 600;">Rp 0</span>
            </div>

            <div class="summary-row total" style="border-top: 1.5px solid var(--light-gray); padding-top: 1rem; font-weight: 700; font-size: 1.15rem; color: var(--text-dark); display: flex; justify-content: space-between;">
                <span>Total Bayar:</span>
                <span style="color: #10B981;">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
            </div>
            
            <p style="font-size: 0.75rem; color: var(--text-muted); margin: 1.25rem 0; line-height: 1.5;">
                * Pembayaran dilakukan secara penuh dengan metode <strong>Bayar di Tempat (COD)</strong> saat barang diambil di toko.
            </p>

            <a href="{{ route('user.checkout') }}" class="btn-checkout" style="background-color: var(--accent-orange); border-radius: 8px; font-weight: 700;">
                Lanjut ke Konfirmasi
            </a>
        </div>
    </div>
@endif
@endsection

@section('scripts')
<script>
    // Adjust End Date Min based on Start Date Selection
    document.getElementById('cart_start_date').addEventListener('change', function() {
        const startDateVal = this.value;
        const endDateInput = document.getElementById('cart_end_date');
        
        const parts = startDateVal.split('-');
        const date = new Date(parts[0], parts[1] - 1, parts[2]);
        date.setDate(date.getDate() + 1);
        
        const yyyy = date.getFullYear();
        const mm = String(date.getMonth() + 1).padStart(2, '0');
        const dd = String(date.getDate()).padStart(2, '0');
        
        endDateInput.min = `${yyyy}-${mm}-${dd}`;
        if (endDateInput.value <= startDateVal) {
            endDateInput.value = `${yyyy}-${mm}-${dd}`;
        }
    });
</script>
@endsection
