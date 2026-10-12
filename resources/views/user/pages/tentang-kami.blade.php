@extends('layouts.user')

@section('title', 'Tentang Kami - CampRent')

@section('content')
<div class="page-header" style="text-align: center; margin-bottom: 3rem;">
    <h1 style="font-size: 2.5rem; font-weight: 800; color: var(--forest-green); font-family: 'Outfit', sans-serif;">Tentang Kami</h1>
    <p style="color: var(--text-muted); font-size: 1.1rem; max-width: 600px; margin: 0.5rem auto 0;">Mengenal lebih dekat siapa kami dan visi misi kami dalam melayani petualangan Anda.</p>
</div>

<div class="content-box" style="background: #FFF; padding: 3rem; border-radius: 20px; box-shadow: 0 10px 40px rgba(12, 43, 26, 0.05); border: 1px solid #ECE7DD; max-width: 800px; margin: 0 auto; line-height: 1.8; color: #1F2E26; font-size: 1.05rem;">
    <h2 style="font-family: 'Outfit', sans-serif; font-size: 1.8rem; margin-bottom: 1rem; color: var(--accent-orange);">CAMPrent</h2>
    <p style="margin-bottom: 1.5rem;"><strong>CAMPrent</strong> adalah penyedia layanan penyewaan peralatan camping dan pendakian terlengkap dan terpercaya. Berawal dari hobi dan kecintaan kami terhadap alam bebas, kami memahami betapa pentingnya peralatan yang aman, nyaman, dan berkualitas dalam setiap petualangan.</p>
    
    <p style="margin-bottom: 1.5rem;">Kami menyadari bahwa membeli peralatan camping yang berkualitas membutuhkan biaya yang tidak sedikit. Oleh karena itu, CAMPrent hadir untuk memberikan solusi penyewaan alat camping dengan harga terjangkau tanpa mengorbankan kualitas dan keamanan.</p>

    <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.4rem; margin-top: 2rem; margin-bottom: 1rem;">Visi Kami</h3>
    <p style="margin-bottom: 1.5rem;">Menjadi partner petualangan terbaik bagi setiap penikmat alam di Indonesia dengan menyediakan layanan dan peralatan kemah yang berkualitas.</p>

    <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.4rem; margin-top: 2rem; margin-bottom: 1rem;">Misi Kami</h3>
    <ul style="padding-left: 1.5rem; margin-bottom: 1.5rem;">
        <li style="margin-bottom: 0.5rem;">Menyediakan peralatan kemah yang aman, bersih, dan terawat.</li>
        <li style="margin-bottom: 0.5rem;">Memberikan kemudahan akses melalui platform penyewaan digital yang modern.</li>
        <li style="margin-bottom: 0.5rem;">Memberikan edukasi kepada penyewa mengenai penggunaan peralatan dan pentingnya menjaga kebersihan alam (Leave No Trace).</li>
    </ul>
    
    <div style="margin-top: 3rem; text-align: center; padding-top: 2rem; border-top: 1px solid #ECE7DD;">
        <p style="font-style: italic; color: var(--text-muted);">"Petualangan yang hebat dimulai dari persiapan yang tepat."</p>
    </div>
</div>
@endsection
