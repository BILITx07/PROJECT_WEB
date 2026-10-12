@extends('layouts.user')

@section('title', 'Kebijakan Privasi - CampRent')

@section('content')
<div class="page-header" style="text-align: center; margin-bottom: 3rem;">
    <h1 style="font-size: 2.5rem; font-weight: 800; color: var(--forest-green); font-family: 'Outfit', sans-serif;">Kebijakan Privasi</h1>
    <p style="color: var(--text-muted); font-size: 1.1rem; max-width: 600px; margin: 0.5rem auto 0;">Komitmen kami dalam melindungi data pribadi Anda.</p>
</div>

<div class="content-box" style="background: #FFF; padding: 3rem; border-radius: 20px; box-shadow: 0 10px 40px rgba(12, 43, 26, 0.05); border: 1px solid #ECE7DD; max-width: 800px; margin: 0 auto; line-height: 1.8; color: #1F2E26;">
    
    <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.4rem; margin-bottom: 1rem;">Pengumpulan Data</h3>
    <p style="margin-bottom: 1.5rem; color: var(--text-muted);">Kami di CAMPrent mengumpulkan informasi pribadi yang Anda berikan secara langsung kepada kami saat mendaftar akun, seperti nama lengkap, alamat email, nomor telepon, dan nomor identitas (KTP/KTM). Informasi ini digunakan murni untuk keperluan verifikasi penyewaan barang dan untuk menghubungi Anda terkait status pesanan Anda.</p>

    <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.4rem; margin-bottom: 1rem;">Penggunaan Data</h3>
    <p style="margin-bottom: 1.5rem; color: var(--text-muted);">Data yang dikumpulkan akan kami gunakan secara eksklusif untuk:</p>
    <ul style="padding-left: 1.5rem; margin-bottom: 1.5rem; color: var(--text-muted);">
        <li>Memproses reservasi / <em>booking</em> penyewaan alat camping Anda.</li>
        <li>Melakukan verifikasi identitas sebagai jaminan keamanan aset barang yang disewakan.</li>
        <li>Meningkatkan pengalaman pengguna di dalam platform website kami.</li>
    </ul>

    <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.4rem; margin-bottom: 1rem;">Keamanan Data & Identitas</h3>
    <p style="margin-bottom: 1.5rem; color: var(--text-muted);">Kami menjaga keamanan identitas Anda dengan serius. Kartu identitas yang Anda titipkan sebagai jaminan akan kami simpan di tempat yang aman selama masa penyewaan, dan akan langsung dikembalikan kepada Anda setelah seluruh perlengkapan dikembalikan tanpa ada kekurangan. Kami berjanji untuk tidak pernah menjual atau membagikan data Anda kepada pihak ketiga.</p>

    <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.4rem; margin-bottom: 1rem;">Pembaruan Kebijakan</h3>
    <p style="color: var(--text-muted);">Kebijakan privasi ini dapat diperbarui sewaktu-waktu tanpa pemberitahuan sebelumnya untuk mematuhi ketentuan hukum yang berlaku. Dengan menggunakan layanan kami, Anda menyetujui pengumpulan dan penggunaan informasi sesuai dengan kebijakan ini.</p>

</div>
@endsection
