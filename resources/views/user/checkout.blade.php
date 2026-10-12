@extends('layouts.user')

@section('title', 'Konfirmasi Sewa - CampRent')

@section('content')
<h2 style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
    <i class="fa-solid fa-file-invoice-dollar" style="color: var(--forest-green);"></i> Konfirmasi Sewa
</h2>

<div class="cart-layout">
    <!-- Items Review & Adjustments -->
    <div style="display:flex; flex-direction:column; gap:1.5rem;">
        <div class="checkout-items-summary">
            <h3 class="receipt-section-title">Detail Barang</h3>
            
            @foreach ($cartItems as $cartItem)
                <div class="cart-item-row" style="padding: 0.75rem 0;">
                    <div class="cart-item-thumb" style="width: 60px; height: 60px;">
                        @if ($cartItem->item->image)
                            <img src="{{ asset('storage/' . $cartItem->item->image) }}" alt="{{ $cartItem->item->name }}">
                        @else
                            <i class="fa-solid fa-tents fa-lg" style="color: var(--light-gray);"></i>
                        @endif
                    </div>
                    
                    <div class="cart-item-info">
                        <h4 class="cart-item-name" style="font-size: 0.95rem;">{{ $cartItem->item->name }}</h4>
                        <span class="cart-item-price" style="font-size: 0.9rem;">Rp {{ number_format($cartItem->item->price_per_day, 0, ',', '.') }}</span>
                    </div>

                    <!-- Inline adjustment like Shopee checkout -->
                    <div class="cart-item-controls" style="flex-direction: row; align-items: center; gap: 1rem;">
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
                        
                        <span style="font-weight: 700; min-width: 90px; text-align: right;">
                            Rp {{ number_format($cartItem->item->price_per_day * $cartItem->quantity * $duration, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            @endforeach
            
            <div style="text-align: right; margin-top: 1rem;">
                <a href="{{ route('user.dashboard') }}" class="btn-check-availability" style="display: inline-block; padding: 0.5rem 1rem; font-size: 0.85rem; text-decoration: none; background-color: var(--forest-green);">
                    <i class="fa-solid fa-plus"></i> Tambah Barang
                </a>
            </div>
        </div>

        <!-- Renter Information card -->
        <div class="checkout-items-summary">
            <h3 class="receipt-section-title">Informasi Penyewa</h3>
            <div class="receipt-grid" style="margin-bottom:0;">
                <div class="receipt-row">
                    <span class="label">Nama Penyewa:</span>
                    <span class="val">{{ auth()->user()->name }}</span>
                </div>
                <div class="receipt-row">
                    <span class="label">No. WhatsApp:</span>
                    <span class="val">{{ auth()->user()->phone_number }}</span>
                </div>
                <div class="receipt-row">
                    <span class="label">NIK (Identitas):</span>
                    <span class="val">{{ auth()->user()->nik }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Final Check & Action Card -->
    <div class="cart-summary-card">
        <h3 class="summary-title">Rincian Pembayaran</h3>
        
        <div class="receipt-grid" style="border-bottom: 1px solid var(--light-gray); padding-bottom: 1rem; margin-bottom: 1rem;">
            <div class="receipt-row">
                <span class="label">Periode Sewa:</span>
                <span class="val" style="font-size:0.85rem; text-align:right;">
                    {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y') }}<br>
                    sampai {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y') }}
                </span>
            </div>
            <div class="receipt-row" style="margin-top: 0.5rem;">
                <span class="label">Durasi Sewa:</span>
                <span class="val">{{ $duration }} hari</span>
            </div>
        </div>

        <form action="{{ route('user.checkout.booking') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Payment Method Selection -->
            <div style="margin: 1.5rem 0;">
                <label style="display:block; font-weight:700; color:var(--text-dark); margin-bottom: 0.5rem; font-size: 0.95rem;">Pilih Metode Pembayaran</label>
                
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <label style="display:flex; align-items:center; gap:0.5rem; padding: 0.75rem; border: 1px solid #ECE7DD; border-radius: 8px; cursor: pointer;">
                        <input type="radio" name="payment_method" value="cod" required onclick="showPaymentInstructions('cod')" style="accent-color: var(--forest-green);">
                        <span style="font-weight: 600;">Bayar di Tempat (COD)</span>
                    </label>
                    <label style="display:flex; align-items:center; gap:0.5rem; padding: 0.75rem; border: 1px solid #ECE7DD; border-radius: 8px; cursor: pointer;">
                        <input type="radio" name="payment_method" value="qris" required onclick="showPaymentInstructions('qris')" style="accent-color: var(--forest-green);">
                        <span style="font-weight: 600;">QRIS (All Payment Apps)</span>
                    </label>
                    <label style="display:flex; align-items:center; gap:0.5rem; padding: 0.75rem; border: 1px solid #ECE7DD; border-radius: 8px; cursor: pointer;">
                        <input type="radio" name="payment_method" value="transfer_bca" required onclick="showPaymentInstructions('bca')" style="accent-color: var(--forest-green);">
                        <span style="font-weight: 600;">Transfer Bank BCA</span>
                    </label>
                    <label style="display:flex; align-items:center; gap:0.5rem; padding: 0.75rem; border: 1px solid #ECE7DD; border-radius: 8px; cursor: pointer;">
                        <input type="radio" name="payment_method" value="transfer_mandiri" required onclick="showPaymentInstructions('mandiri')" style="accent-color: var(--forest-green);">
                        <span style="font-weight: 600;">Transfer Bank Mandiri</span>
                    </label>
                </div>
                @error('payment_method')
                    <span style="color: #DC2626; font-size: 0.8rem;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Dynamic Payment Instructions -->
            <div id="payment-instructions" style="display: none; margin-bottom: 1.5rem; background-color: #F8F5EE; padding: 1rem; border-radius: 8px; border: 1px dashed #DFD6C4;">
                <!-- Content will be injected via JS -->
            </div>

            <!-- Proof of Payment Upload -->
            <div id="proof-upload-section" style="margin-bottom: 1.5rem;">
                <label style="display:block; font-weight:700; color:var(--text-dark); margin-bottom: 0.5rem; font-size: 0.95rem;">Unggah Bukti Pembayaran</label>
                <input type="file" id="proof-upload-input" name="payment_proof" accept="image/jpeg,image/png,image/jpg" required style="width: 100%; padding: 0.5rem; border: 1px solid #ECE7DD; border-radius: 6px; font-size: 0.9rem; background: #fff;">
                <span style="display:block; font-size: 0.75rem; color: var(--text-muted); margin-top: 0.25rem;">Format: JPG, JPEG, PNG. Maks 2MB.</span>
                @error('payment_proof')
                    <span style="color: #DC2626; font-size: 0.8rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="summary-row total" style="margin-top: 1rem; border-top: 2px dashed #ECE7DD; padding-top: 1rem;">
                <span>Total Bayar:</span>
                <span style="color: var(--forest-green);">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
            </div>

            <div class="receipt-info-box" style="margin: 1.5rem 0 1rem; padding: 0.75rem; font-size: 0.8rem; background-color:#F5EFE6; border-color:#DFD6C4;">
                <i class="fa-solid fa-circle-info" style="color: var(--primary-brown); margin-right: 0.25rem;"></i>
                Dengan melakukan konfirmasi, Anda menyetujui seluruh Syarat & Ketentuan CampRent.
            </div>

            <button type="submit" class="btn-checkout" style="border: none; font-size: 1.05rem; cursor: pointer; width: 100%;">
                Konfirmasi Sewa & Bayar
            </button>
        </form>

        <script>
            function showPaymentInstructions(method) {
                const container = document.getElementById('payment-instructions');
                const proofSection = document.getElementById('proof-upload-section');
                const proofInput = document.getElementById('proof-upload-input');
                
                container.style.display = 'block';
                let content = '';

                if (method === 'cod') {
                    proofSection.style.display = 'none';
                    proofInput.removeAttribute('required');
                    content = `
                        <div>
                            <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.25rem;">Bayar di Tempat (COD)</p>
                            <p style="font-size: 0.95rem; font-weight: 600; color: var(--text-dark); margin-bottom: 0.15rem;">Silakan lakukan pembayaran langsung di toko kami saat Anda mengambil alat yang disewa.</p>
                        </div>
                    `;
                } else {
                    proofSection.style.display = 'block';
                    proofInput.setAttribute('required', 'required');
                }

                if (method === 'qris') {
                    content = `
                        <div style="text-align: center;">
                            <p style="font-size: 0.85rem; font-weight: 600; margin-bottom: 0.5rem;">Scan QRIS di bawah ini:</p>
                            <img src="{{ asset('images/qris-bca.jpg') }}" alt="QRIS BCA" style="width: 220px; height: auto; margin: 0 auto; display: block; border-radius: 8px; border: 2px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            <p style="font-size: 0.9rem; font-weight: 700; color: var(--text-dark); margin-top: 0.75rem;">A.n. BILLIANTO TIMOTHY</p>
                            <p style="font-size: 0.8rem; color: var(--text-muted);">BCA - 6465598691</p>
                        </div>
                    `;
                } else if (method === 'bca') {
                    content = `
                        <div>
                            <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.25rem;">Transfer ke Bank BCA</p>
                            <p style="font-size: 1.2rem; font-weight: 700; color: #0066AE; letter-spacing: 1px; margin-bottom: 0.15rem;">6465598691</p>
                            <p style="font-size: 0.9rem; font-weight: 600; color: var(--text-dark);">A.n. BILLIANTO TIMOTHY</p>
                        </div>
                    `;
                } else if (method === 'mandiri') {
                    content = `
                        <div>
                            <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.25rem;">Transfer ke Bank Mandiri</p>
                            <p style="font-size: 1.1rem; font-weight: 700; color: #F2A900; letter-spacing: 1px; margin-bottom: 0.15rem;">1370 0012 3456 7</p>
                            <p style="font-size: 0.85rem; font-weight: 600; color: var(--text-dark);">A.n. CAMPrent Official</p>
                        </div>
                    `;
                }

                container.innerHTML = content;
            }
        </script>
        
        <a href="{{ route('user.cart') }}" style="display:block; text-align:center; margin-top: 0.75rem; font-size:0.85rem; color:var(--text-muted); text-decoration:none;">
            Kembali ke Keranjang
        </a>
    </div>
</div>
@endsection
