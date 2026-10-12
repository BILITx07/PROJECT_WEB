@extends('layouts.user')

@section('title', 'Syarat & Ketentuan - CampRent')

@section('content')
<div class="page-header" style="text-align: center; margin-bottom: 3rem;">
    <h1 style="font-size: 2.5rem; font-weight: 800; color: var(--forest-green); font-family: 'Outfit', sans-serif;">Syarat & Ketentuan</h1>
    <p style="color: var(--text-muted); font-size: 1.1rem; max-width: 600px; margin: 0.5rem auto 0;">Mohon baca dengan teliti syarat dan ketentuan penyewaan di CAMPrent.</p>
</div>

<div class="content-box" style="background: #FFF; padding: 3rem; border-radius: 20px; box-shadow: 0 10px 40px rgba(12, 43, 26, 0.05); border: 1px solid #ECE7DD; max-width: 800px; margin: 0 auto; line-height: 1.8; color: #1F2E26;">
    
    <ol style="padding-left: 1.25rem;">
        <li style="margin-bottom: 1.5rem;">
            <strong>Persyaratan Identitas</strong><br>
            <span style="color: var(--text-muted);">Penyewa wajib menyerahkan kartu identitas asli (KTP/SIM/Kartu Pelajar) yang masih berlaku selama masa peminjaman sebagai jaminan utama.</span>
        </li>
        <li style="margin-bottom: 1.5rem;">
            <strong>Periode Sewa & Denda</strong><br>
            <span style="color: var(--text-muted);">Masa sewa dihitung per hari (24 jam). Keterlambatan pengembalian barang akan dikenakan denda biaya sewa 1 hari penuh untuk setiap 12 jam keterlambatan.</span>
        </li>
        <li style="margin-bottom: 1.5rem;">
            <strong>Kerusakan & Kehilangan</strong><br>
            <span style="color: var(--text-muted);">Setiap barang sewa diperiksa bersama sebelum dan sesudah disewa. Apabila terjadi kerusakan atau kehilangan barang, penyewa wajib mengganti biaya perbaikan atau pembelian barang baru senilai harga pasar.</span>
        </li>
        <li style="margin-bottom: 1.5rem;">
            <strong>Pembayaran & Pembatalan</strong><br>
            <span style="color: var(--text-muted);">Pembayaran DP (Down Payment) minimal 50% dilakukan saat booking disetujui, atau pembayaran penuh melalui QRIS. Pembatalan booking H-1 sebelum tanggal mulai sewa akan dikenakan hangus uang muka / DP.</span>
        </li>
        <li style="margin-bottom: 0;">
            <strong>Pemeliharaan Kebersihan</strong><br>
            <span style="color: var(--text-muted);">Barang camping harus dikembalikan dalam keadaan bersih dan kering. Pengembalian tenda/alat masak dalam kondisi kotor parah atau basah kuyup akan dikenakan biaya <em>laundry</em>/kebersihan tambahan sebesar Rp 15.000 per unit.</span>
        </li>
    </ol>

</div>
@endsection
