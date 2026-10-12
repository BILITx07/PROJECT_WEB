<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CampRent - Sewa Alat Camping')</title>
    <link rel="stylesheet" href="{{ asset('css/user.css') }}?v={{ time() + 14 }}">
    <!-- Icons helper -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <!-- Header Overlay Wrapper -->
    <div id="main-header-wrapper" style="position: absolute; top: 0; left: 0; width: 100%; z-index: 1000;">
        <!-- Top Bar -->
        <div class="top-bar {{ Route::is('user.dashboard') ? 'transparent-mode' : '' }}">
        <div class="top-bar-left">
            <div class="top-bar-contact">
                <i class="fa-solid fa-phone"></i>
                <span>082144380839</span>
            </div>
            <div class="top-bar-contact">
                <i class="fa-solid fa-envelope"></i>
                <span>camprent@gmail.com</span>
            </div>
        </div>
        <div class="top-bar-right">
            <span>Lebih dari <strong style="color: #4ade80;">40+</strong> peralatan camping</span>
            <a href="{{ route('user.products') }}" class="top-bar-btn">Lihat <i class="fa-solid fa-arrow-right"></i></a>
        </div>
    </div>

    <header class="user-header {{ Route::is('user.dashboard') ? 'transparent-mode' : '' }}">
        <div class="header-container">
            <a href="{{ route('user.dashboard') }}" class="brand-link">
                <!-- CampRent SVG Logo -->
                <svg viewBox="0 0 100 100" style="height: 45px; width: auto;" xmlns="http://www.w3.org/2000/svg">
                    <path d="M50 10 L10 90 L35 90 L50 60 L65 90 L90 90 Z" fill="#FF7A00"/>
                    <polygon points="35 90, 50 60, 65 90" fill="#FFFFFF"/>
                </svg>
            </a>
            <nav class="nav-menu">
                <div class="category-dropdown">
                    <button class="nav-link dropdown-trigger" style="background: transparent; border: none; cursor: pointer; padding: 0;">
                        Kategori <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i>
                    </button>
                    <div class="dropdown-menu category-menu">
                        @if(isset($navCategories) && count($navCategories) > 0)
                            @foreach($navCategories as $category)
                                <a href="{{ route('user.products', ['category' => $category]) }}">{{ $category }}</a>
                            @endforeach
                        @else
                            <a href="{{ route('user.products') }}">Semua Peralatan</a>
                        @endif
                    </div>
                </div>
                <a href="{{ route('user.cara_sewa') }}" class="nav-link {{ Route::is('user.cara_sewa') ? 'active' : '' }}">
                    Cara Sewa
                </a>
                @auth
                <a href="{{ route('user.bookings') }}" class="nav-link {{ Route::is('user.bookings') ? 'active' : '' }}">
                    Booking Saya
                </a>
                @endauth
                
                @auth
                    <a href="{{ route('user.wishlist') }}" class="nav-link" title="Wishlist">
                        <i class="fa-regular fa-heart"></i>
                    </a>
                @endauth
                
                <a href="{{ route('user.cart') }}" class="cart-btn cart-badge-container" title="Keranjang">
                    <i class="fa-solid fa-cart-shopping"></i>
                    @if (isset($cartCount) && $cartCount > 0)
                        <span class="cart-badge">{{ $cartCount }}</span>
                    @elseif (auth()->check() && auth()->user()->cartItems()->count() > 0)
                        <span class="cart-badge">{{ auth()->user()->cartItems()->sum('quantity') }}</span>
                    @endif
                </a>
                
                @if (auth()->check())
                    <div class="user-profile-dropdown">
                        <button class="dropdown-trigger" style="background: transparent; padding: 0; color: #fff; font-weight: 500;">
                            <i class="fa-solid fa-user"></i>
                            <span>Halo, {{ explode(' ', auth()->user()->name)[0] }}</span>
                            <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a href="{{ route('user.profile') }}"><i class="fa-solid fa-user-gear"></i> Profil Saya</a>
                            <hr>
                            <form action="{{ route('user.logout') }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" style="width: 100%; border: none; background: none; font-family: inherit; font-size: inherit; text-align: left; padding: 0.75rem 1.25rem; color: #1F2E26; cursor: pointer; display: flex; align-items: center; gap: 0.75rem;">
                                    <i class="fa-solid fa-sign-out-alt"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('user.login') }}" class="nav-link" style="font-weight: 600;">
                        <i class="fa-solid fa-user"></i> Masuk
                    </a>
                @endif
            </nav>
        </div>
    </header>
    </div> <!-- End Header Overlay Wrapper -->

    @yield('hero')

    <main class="main-container {{ View::hasSection('hero') ? 'no-top-padding' : '' }}">
        <!-- Success Alert -->
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Error Alert -->
        @if (session('error'))
            <div class="alert alert-danger">
                <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
            </div>
        @endif

        <!-- Warning Alert -->
        @if (session('warning'))
            <div class="alert alert-warning">
                <i class="fa-solid fa-circle-exclamation"></i> {{ session('warning') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="main-footer" style="background-color: #000000; color: #fff; padding: 4rem 2rem 2rem 2rem;">
        <div class="footer-container" style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 3rem;">
            <!-- Column 1 -->
            <div class="footer-column" style="display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div class="footer-brand" style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                        <svg class="brand-logo" viewBox="0 0 512 512" fill="#FF7A00" xmlns="http://www.w3.org/2000/svg" style="height: 32px; width: auto;">
                            <path d="M256 0L0 448h144l112-256 112 256h144L256 0z"/>
                            <path d="M256 224L176 384h160L256 224z" fill="#FFF"/>
                        </svg>
                        <span class="footer-brand-title" style="font-family: 'Outfit', sans-serif; font-size: 1.75rem; font-weight: 800; color: #fff;">CAMPrent</span>
                    </div>
                    <p class="footer-desc" style="margin-bottom: 1rem; color: #d1d5db; line-height: 1.6; font-size: 0.95rem;">
                        Solusi sewa alat camping terbaik<br>untuk setiap petualanganmu.
                    </p>
                    <p class="footer-desc" style="font-size: 0.8rem; color: #9ca3af; margin-bottom: 3rem;">
                        &copy; {{ date('Y') }} CAMPrent. All rights reserved.
                    </p>
                </div>
                
                <div>
                    <h4 style="font-family: 'Outfit', sans-serif; font-size: 1.2rem; font-weight: 700; color: #fff; margin-bottom: 1rem;">Ikuti Kami</h4>
                    <div class="footer-socials" style="display: flex; gap: 0.75rem;">
                        <a href="#" style="width: 35px; height: 35px; background: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none; transition: background 0.3s;"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" style="width: 35px; height: 35px; background: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none; transition: background 0.3s;"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" style="width: 35px; height: 35px; background: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none; transition: background 0.3s;"><i class="fa-brands fa-tiktok"></i></a>
                    </div>
                </div>
            </div>

            <!-- Column 2 -->
            <div class="footer-column">
                <h4 style="font-family: 'Outfit', sans-serif; font-size: 1.2rem; font-weight: 700; color: #fff; margin-bottom: 1.5rem;">Menu</h4>
                <ul class="footer-links" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 1rem;">
                    <li><a href="{{ route('user.dashboard') }}" style="color: #d1d5db; text-decoration: none; transition: color 0.3s;">Jelajah</a></li>
                    <li><a href="{{ route('user.bookings') }}" style="color: #d1d5db; text-decoration: none; transition: color 0.3s;">Booking Saya</a></li>
                    <li><a href="{{ route('user.cart') }}" style="color: #d1d5db; text-decoration: none; transition: color 0.3s;">Keranjang</a></li>
                </ul>
            </div>

            <!-- Column 3 -->
            <div class="footer-column">
                <h4 style="font-family: 'Outfit', sans-serif; font-size: 1.2rem; font-weight: 700; color: #fff; margin-bottom: 1.5rem;">Informasi</h4>
                <ul class="footer-links" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 1rem;">
                    <li><a href="{{ route('user.tentang_kami') }}" style="color: #d1d5db; text-decoration: none; transition: color 0.3s;">Tentang Kami</a></li>
                    <li><a href="{{ route('user.cara_sewa') }}" style="color: #d1d5db; text-decoration: none; transition: color 0.3s;">Cara Sewa</a></li>
                    <li><a href="{{ route('user.syarat_ketentuan') }}" style="color: #d1d5db; text-decoration: none; transition: color 0.3s;">Syarat & Ketentuan</a></li>
                    <li><a href="{{ route('user.kebijakan_privasi') }}" style="color: #d1d5db; text-decoration: none; transition: color 0.3s;">Kebijakan Privasi</a></li>
                </ul>
            </div>

            <!-- Column 4 -->
            <div class="footer-column">
                <h4 style="font-family: 'Outfit', sans-serif; font-size: 1.2rem; font-weight: 700; color: #fff; margin-bottom: 1.5rem;">Kontak</h4>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <div class="footer-contact-item" style="display: flex; align-items: center; gap: 0.75rem; color: #d1d5db;">
                        <i class="fa-solid fa-phone" style="color: #FF7A00;"></i>
                        <span>0812-3456-7890</span>
                    </div>
                    <div class="footer-contact-item" style="display: flex; align-items: center; gap: 0.75rem; color: #d1d5db;">
                        <i class="fa-solid fa-envelope" style="color: #FF7A00;"></i>
                        <span>camprent@gmail.com</span>
                    </div>
                    <div class="footer-contact-item" style="display: flex; align-items: center; gap: 0.75rem; color: #d1d5db;">
                        <i class="fa-solid fa-location-dot" style="color: #FF7A00;"></i>
                        <span>Pontianak, Indonesia</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Sticky Header Effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.user-header');
            const topBar = document.querySelector('.top-bar');
            
            if (window.scrollY > topBar.offsetHeight) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    </script>
    
    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800, // Durasi animasi 0.8 detik (elegan)
            once: true,    // Animasi hanya berjalan sekali saat pertama kali di-scroll
            offset: 100,   // Animasi mulai 100px sebelum elemen terlihat
            easing: 'ease-out-cubic' // Pergerakan halus
        });
    </script>
    
    @yield('scripts')
</body>
</html>
