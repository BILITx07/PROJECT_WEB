@extends('layouts.admin')

@section('title', 'Syarat & Ketentuan')
@section('page-title', 'Syarat & Ketentuan')

@section('content')

<h2 style="font-size:22px;font-weight:700;margin-bottom:18px;">Syarat & Ketentuan</h2>

<div class="card">
  <div style="display:flex;flex-direction:column;gap:20px;color:var(--text-muted);font-size:14px;line-height:1.7;">

    <div>
      <h3 style="font-size:15px;font-weight:700;color:var(--text-dark);margin-bottom:6px;">
        1. Persyaratan Identitas
      </h3>
      <p>Penyewa wajib menyerahkan kartu identitas asli (KTP/SIM/Kartu Pelajar) yang masih berlaku selama masa peminjaman sebagai jaminan utama.</p>
    </div>

    <div>
      <h3 style="font-size:15px;font-weight:700;color:var(--text-dark);margin-bottom:6px;">
        2. Periode Sewa
      </h3>
      <p>Masa sewa dihitung per hari (24 jam). Keterlambatan pengembalian barang akan dikenakan denda biaya sewa 1 hari penuh untuk setiap 12 jam keterlambatan.</p>
    </div>

    <div>
      <h3 style="font-size:15px;font-weight:700;color:var(--text-dark);margin-bottom:6px;">
        3. Kerusakan & Kehilangan
      </h3>
      <p>Setiap barang sewa diperiksa bersama sebelum dan sesudah disewa. Apabila terjadi kerusakan atau kehilangan barang, penyewa wajib mengganti biaya perbaikan atau pembelian barang baru senilai harga pasar.</p>
    </div>

    <div>
      <h3 style="font-size:15px;font-weight:700;color:var(--text-dark);margin-bottom:6px;">
        4. Pembayaran & Pembatalan
      </h3>
      <p>Pembayaran DP (Down Payment) minimal 30% dilakukan saat booking disetujui. Pembatalan booking H-1 sebelum tanggal mulai sewa akan dikenakan hangus DP sebesar 50%.</p>
    </div>

    <div>
      <h3 style="font-size:15px;font-weight:700;color:var(--text-dark);margin-bottom:6px;">
        5. Pemeliharaan Kebersihan
      </h3>
      <p>Barang camping dikembalikan dalam keadaan bersih dan kering. Pengembalian tenda/alat masak dalam kondisi kotor parah atau basah kuyup akan dikenakan biaya laundry kebersihan tambahan sebesar Rp 15.000 per unit.</p>
    </div>

  </div>
</div>

@endsection
