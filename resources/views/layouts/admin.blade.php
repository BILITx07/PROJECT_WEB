<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin') – CampRent</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  
</head>
<body>
<div class="admin-layout">

  <!-- ── Sidebar ───────────────────────────────── -->
  <aside class="sidebar">
    <div class="sidebar-brand" style="border-bottom: 1px solid rgba(255,255,255,0.05); padding: 1.5rem 1.25rem;">
        <!-- Golden Tent Logo SVG -->
        <svg viewBox="0 0 512 512" fill="#FF7A00" xmlns="http://www.w3.org/2000/svg" style="height: 32px; width: auto; margin-right: 0.5rem; flex-shrink:0;">
            <path d="M256 0L0 448h144l112-256 112 256h144L256 0z"/>
            <path d="M256 224L176 384h160L256 224z" fill="#FFF"/>
        </svg>
        <div class="sidebar-brand-text">
            <h2 style="font-family: 'Urbanist', sans-serif; font-size: 1.15rem; font-weight: 800; color: #fff; letter-spacing: 0.5px; line-height: 1.2; margin: 0;">CAMPrent</h2>
            <span style="font-size: 0.7rem; color: var(--accent-orange); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block;">Admin Panel</span>
        </div>
    </div>

    <nav class="sidebar-nav">
      <a href="http://localhost:8001/" target="_blank">
        <i class="fa-solid fa-arrow-up-right-from-square" style="width:18px;"></i>
        <span>Lihat Web</span>
      </a>

      <a href="{{ route('admin.dashboard') }}"
         class="{{ Route::is('admin.dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-house-chimney" style="width:18px;"></i>
        <span>Dashboard</span>
      </a>

      <a href="{{ route('admin.items.index') }}"
         class="{{ Route::is('admin.items.index') ? 'active' : '' }}">
        <i class="fa-solid fa-boxes-stacked" style="width:18px;"></i>
        <span>Data Barang</span>
      </a>

      <a href="{{ route('admin.bookings.index') }}"
         class="{{ Route::is('admin.bookings.*') ? 'active' : '' }}">
        <i class="fa-solid fa-calendar-check" style="width:18px;"></i>
        <span>Data Booking</span>
      </a>


      <a href="{{ route('admin.laporan') }}"
         class="{{ Route::is('admin.laporan') ? 'active' : '' }}">
        <i class="fa-solid fa-chart-line" style="width:18px;"></i>
        <span>Laporan</span>
      </a>

      <a href="{{ route('admin.users.index') }}"
         class="{{ Route::is('admin.users.index') ? 'active' : '' }}">
        <i class="fa-solid fa-users" style="width:18px;"></i>
        <span>Pengguna</span>
      </a>
    </nav>

    <!-- Sidebar Bottom Tent Camp Illustration -->
    <div class="sidebar-illustration">
        <svg viewBox="0 0 200 120" width="100%" height="auto">
            <rect width="200" height="120" fill="transparent" />
            <polygon points="30,80 15,110 45,110" fill="#04140C" />
            <polygon points="30,65 20,95 40,95" fill="#062013" />
            <polygon points="170,85 155,110 185,110" fill="#04140C" />
            <polygon points="170,70 160,95 180,95" fill="#062013" />
            
            <polygon points="60,90 40,120 80,120" fill="#030E08" />
            <polygon points="60,70 45,100 75,100" fill="#04180E" />
            <polygon points="140,90 120,120 160,120" fill="#030E08" />
            <polygon points="140,70 125,100 155,100" fill="#04180E" />
            
            <path d="M-10 120 Q50 90 100 105 Q150 120 210 120 Z" fill="#04160D" />
            
            <polygon points="100,85 75,120 125,120" fill="#FF7A00" />
            <polygon points="100,85 100,120 125,120" fill="#E05A00" />
            <polygon points="100,98 87,120 113,120" fill="#062013" />
            <polygon points="100,98 95,120 87,120" fill="#FFA34D" />
            
            <circle cx="20" cy="30" r="1" fill="#FFF" opacity="0.6" />
            <circle cx="50" cy="20" r="1.5" fill="#FFF" opacity="0.8" />
            <circle cx="150" cy="25" r="1" fill="#FFF" opacity="0.4" />
            <circle cx="180" cy="40" r="1.5" fill="#FFF" opacity="0.7" />
            
            <circle cx="65" cy="118" r="4" fill="#505050" opacity="0.3" />
            <polygon points="65,112 62,118 68,118" fill="#FF4D00" />
        </svg>
    </div>


  </aside>

  <!-- ── Main ──────────────────────────────────── -->
  <div class="main-content">
    <div class="topbar-admin">
      <div class="topbar-search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" placeholder="Cari sesuatu...">
      </div>
      <div class="topbar-right">
        @php
            $recentBookings = \App\Models\Booking::latest()->take(5)->get();
            $unreadCount = \App\Models\Booking::where('status', 'menunggu')->count();
        @endphp
        <div class="topbar-notif" onclick="document.getElementById('notifDropdown').style.display = document.getElementById('notifDropdown').style.display === 'none' ? 'block' : 'none'" style="position: relative; cursor: pointer;">
          <i class="fa-regular fa-bell"></i>
          <span class="notif-badge" id="notifBadgeCount" style="{{ $unreadCount > 0 ? '' : 'display: none;' }}">{{ $unreadCount }}</span>
          
          <!-- Dropdown Notifikasi -->
          <div class="notif-dropdown" id="notifDropdown" style="display: none; position: absolute; top: 40px; right: 0; width: 320px; background: white; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); z-index: 1000; border: 1px solid #ECE7DD; overflow: hidden; text-align: left; cursor: default;" onclick="event.stopPropagation()">
            <div style="padding: 15px; border-bottom: 1px solid #ECE7DD; font-weight: bold; color: var(--forest-green); background: #f8f9fa;">
                Notifikasi Pesanan
            </div>
            <div id="notifList" style="max-height: 300px; overflow-y: auto;">
                @forelse($recentBookings as $booking)
                <div class="notif-item" style="padding: 12px 15px; border-bottom: 1px solid #f1f1f1; font-size: 0.85rem; line-height: 1.4;">
                    <strong style="color: var(--text-dark);">{{ $booking->customer_name }}</strong> membuat pesanan (<span style="color:var(--accent-orange); font-weight:600;">{{ $booking->booking_code }}</span>).<br>
                    <span style="color: #888; font-size: 0.75rem;"><i class="fa-regular fa-clock"></i> {{ $booking->created_at->diffForHumans() }}</span>
                </div>
                @empty
                <div style="padding: 15px; text-align: center; color: #888; font-size: 0.85rem;" id="emptyNotif">Belum ada notifikasi</div>
                @endforelse
            </div>
            <a href="{{ route('admin.bookings.index') }}" style="display: block; text-align: center; padding: 10px; background: #f8f9fa; color: var(--forest-green); font-size: 0.85rem; text-decoration: none; font-weight: bold;">Lihat Semua Booking</a>
          </div>
        </div>
        <div class="topbar-user" onclick="document.getElementById('userDropdown').style.display = document.getElementById('userDropdown').style.display === 'none' ? 'block' : 'none'" style="position: relative; cursor: pointer;">
          <img src="https://ui-avatars.com/api/?name=Admin&background=0C2D1C&color=fff&rounded=true" alt="Admin Avatar" class="topbar-avatar">
          <div class="topbar-user-info">
            <span class="user-name">Admin</span>
            <span class="user-role">Administrator</span>
          </div>
          
          <!-- Dropdown Profil & Logout -->
          <div class="user-dropdown" id="userDropdown" style="display: none; position: absolute; top: 45px; right: 0; width: 200px; background: white; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); z-index: 1000; border: 1px solid #ECE7DD; overflow: hidden; text-align: left;" onclick="event.stopPropagation()">
            <div style="padding: 12px 15px; border-bottom: 1px solid #ECE7DD; background: #f8f9fa;">
              <div style="font-weight: 700; color: var(--text-dark);">Admin</div>
              <div style="font-size: 0.75rem; color: #888;">admin@camprent.com</div>
            </div>
            <div style="padding: 5px 0;">
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" style="width: 100%; padding: 10px 15px; background: none; border: none; color: #dc2626; text-align: left; cursor: pointer; display: flex; align-items: center; gap: 10px; font-weight: 600; transition: background 0.2s;" onmouseover="this.style.backgroundColor='#fef2f2'" onmouseout="this.style.backgroundColor='transparent'">
                  <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar Akun
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="page-body">
      @if(session('success'))
        <div class="alert alert-success">
          <i class="fa-solid fa-circle-check"></i>
          {{ session('success') }}
        </div>
      @endif

      @if(session('error'))
        <div class="alert alert-danger">
          <i class="fa-solid fa-triangle-exclamation"></i>
          {{ session('error') }}
        </div>
      @endif

      @if($errors->any())
        <div class="alert alert-danger">
          <i class="fa-solid fa-triangle-exclamation"></i>
          {{ $errors->first() }}
        </div>
      @endif

      @yield('content')
    </div>
  </div>

</div>

<!-- Elemen Audio Tersembunyi (Pre-loaded) -->
<audio id="notifSound" src="{{ asset('audio/jokowi_notif.mp3') }}" preload="auto" loop></audio>

@yield('scripts')

  <!-- Pusher & SweetAlert2 untuk Notifikasi In-App -->
  @if(env('PUSHER_APP_KEY'))
  <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    // Enable pusher logging untuk melihat status koneksi di Console
    Pusher.logToConsole = true;

    var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
      cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
    });

    var channel = pusher.subscribe('admin-notifications');
    channel.bind('BookingCreated', function(data) {
      // Tambahkan data ke dropdown secara dinamis tanpa perlu refresh halaman
      var notifList = document.getElementById('notifList');
      var emptyNotif = document.getElementById('emptyNotif');
      if(emptyNotif) emptyNotif.style.display = 'none';
      
      var newItem = `
        <div class="notif-item" style="padding: 12px 15px; border-bottom: 1px solid #f1f1f1; font-size: 0.85rem; line-height: 1.4; background-color: #f0fdf4;">
            <strong style="color: var(--text-dark);">${data.message}</strong><br>
            <span style="color: #888; font-size: 0.75rem;"><i class="fa-regular fa-clock"></i> Baru saja</span>
        </div>
      `;
      notifList.insertAdjacentHTML('afterbegin', newItem);
      
      // Perbarui angka badge merah
      var badge = document.getElementById('notifBadgeCount');
      var currentCount = parseInt(badge.innerText) || 0;
      badge.innerText = currentCount + 1;
      badge.style.display = 'flex';

      // Menampilkan Toast indah di pojok kanan atas
      Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: 'Pesanan Baru!',
        text: data.message,
        showConfirmButton: false,
        timer: 10000,
        timerProgressBar: true,
      });
      
      // Memutar notifikasi suara kustom (Pak Jokowi) secara berulang (Loop) selama 10 detik
      var audioElem = document.getElementById('notifSound');
      
      // Coba putar suaranya
      audioElem.play().catch(function(error) {
          console.log("Browser memblokir auto-play. Anda harus mengklik area mana saja di layar admin terlebih dahulu.");
          
          // Fallback: Munculkan tombol untuk memutar suara secara manual jika diblokir
          Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'warning',
            title: 'Pesanan Baru!',
            text: 'Klik di sini untuk memutar peringatan suara.',
            showConfirmButton: true,
            confirmButtonText: 'Putar Suara'
          }).then((result) => {
            if (result.isConfirmed) {
                audioElem.play();
                setTimeout(function() {
                    audioElem.pause();
                    audioElem.currentTime = 0;
                }, 10000);
            }
          });
      });
      
      // Hentikan suara tepat setelah 10 detik berlalu
      setTimeout(function() {
          audioElem.pause();
          audioElem.currentTime = 0; // Kembalikan rekaman ke awal
      }, 10000);
      
    });
  </script>
  @endif

</body>
</html>
