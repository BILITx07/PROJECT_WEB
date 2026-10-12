@extends('layouts.user')

@section('title', 'Cara Sewa - CampRent')

@section('content')
<div class="page-header" style="text-align: center; margin-bottom: 3rem;">
    <h1 style="font-size: 2.5rem; font-weight: 800; color: var(--forest-green); font-family: 'Outfit', sans-serif;">Cara Sewa</h1>
    <p style="color: var(--text-muted); font-size: 1.1rem; max-width: 600px; margin: 0.5rem auto 0;">Langkah mudah menyewa perlengkapan camping idaman Anda.</p>
</div>

<div class="content-box" style="background: #FFF; padding: 3rem; border-radius: 20px; box-shadow: 0 10px 40px rgba(12, 43, 26, 0.05); border: 1px solid #ECE7DD; max-width: 800px; margin: 0 auto; color: #1F2E26;">
    
    <div style="display: flex; gap: 1.5rem; margin-bottom: 2rem;">
        <div style="width: 50px; height: 50px; background: var(--forest-green); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 800; flex-shrink: 0;">1</div>
        <div>
            <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.4rem; margin-bottom: 0.5rem; margin-top: 0.25rem;">Pilih Tanggal dan Barang</h3>
            <p style="line-height: 1.6; color: var(--text-muted);">Masuk ke halaman utama, lalu pilih tanggal peminjaman dan pengembalian Anda. Cari dan pilih barang atau paket camping yang Anda butuhkan, kemudian masukkan ke dalam <strong>Keranjang</strong>.</p>
        </div>
    </div>

    <div style="display: flex; gap: 1.5rem; margin-bottom: 2rem;">
        <div style="width: 50px; height: 50px; background: var(--forest-green); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 800; flex-shrink: 0;">2</div>
        <div>
            <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.4rem; margin-bottom: 0.5rem; margin-top: 0.25rem;">Checkout Pesanan</h3>
            <p style="line-height: 1.6; color: var(--text-muted);">Buka Keranjang Anda, periksa kembali barang yang disewa. Jika sudah sesuai, tekan tombol <strong>Checkout</strong>. Pada halaman Checkout, pilih metode pembayaran Anda (tersedia QRIS, Transfer Bank, maupun Bayar di Tempat/COD).</p>
        </div>
    </div>

    <div style="display: flex; gap: 1.5rem; margin-bottom: 2rem;">
        <div style="width: 50px; height: 50px; background: var(--forest-green); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 800; flex-shrink: 0;">3</div>
        <div>
            <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.4rem; margin-bottom: 0.5rem; margin-top: 0.25rem;">Konfirmasi & Ambil Barang</h3>
            <p style="line-height: 1.6; color: var(--text-muted);">Setelah melakukan pembayaran (kecuali COD) dan mengunggah bukti bayar, admin kami akan mengonfirmasi pesanan Anda. Jika sudah dikonfirmasi, Anda dapat datang ke <em>Basecamp</em> kami pada tanggal peminjaman dengan membawa Identitas (KTP/KTM asli) sebagai jaminan.</p>
        </div>
    </div>

    <div style="display: flex; gap: 1.5rem;">
        <div style="width: 50px; height: 50px; background: var(--forest-green); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 800; flex-shrink: 0;">4</div>
        <div>
            <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.4rem; margin-bottom: 0.5rem; margin-top: 0.25rem;">Kembalikan Barang</h3>
            <p style="line-height: 1.6; color: var(--text-muted);">Kembalikan barang sesuai dengan tanggal pengembalian yang telah disepakati. Pastikan barang dikembalikan dalam keadaan kering, bersih, dan tidak rusak untuk menghindari biaya tambahan.</p>
        </div>
    </div>

</div>
@endsection
