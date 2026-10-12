<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk / Daftar - CampRent</title>
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
</head>
<body>
    <div class="auth-wrapper">
        <!-- Sidebar Branding -->
        <div class="auth-sidebar">
            <svg class="auth-sidebar-logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="m8 3 4 8 5-5 5 15H2L8 3z"/>
                <path d="M12 11v10"/>
                <path d="m2 21 10-10 10 10"/>
            </svg>
            <h1 class="auth-sidebar-title">CAMPRENT</h1>
            <p class="auth-sidebar-desc">Penyewaan Alat Camping Terbaik untuk Petualangan Luar Ruangan Anda. Sewa mudah, liburan nyaman!</p>
        </div>

        <!-- Forms Content -->
        <div class="auth-content">
            <div class="auth-card">
                <!-- Tabs headers -->
                <div class="auth-tabs-headers">
                    <div class="auth-tab-title active" onclick="switchTab('login')">Masuk</div>
                    <div class="auth-tab-title" onclick="switchTab('register')">Daftar Baru</div>
                </div>

                <!-- Display Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul style="list-style: none;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Login Panel -->
                <div id="login-panel" class="auth-form-panel active">
                    <form action="{{ route('user.perform_login', [], false) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="login-email">Email</label>
                            <input type="email" name="email" id="login-email" class="form-input" placeholder="contoh@email.com" value="{{ old('email') }}" autocomplete="username" required>
                        </div>
                        <div class="form-group">
                            <label for="login-password">Password</label>
                            <input type="password" name="password" id="login-password" class="form-input" placeholder="••••••••" autocomplete="current-password" required>
                        </div>
                        <button type="submit" class="btn-auth-submit">Masuk Sekarang</button>
                    </form>
                </div>

                <!-- Register Panel -->
                <div id="register-panel" class="auth-form-panel">
                    <form action="{{ route('user.register', [], false) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="reg-name">Nama Lengkap</label>
                            <input type="text" name="name" id="reg-name" class="form-input" placeholder="Nama lengkap sesuai KTP" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="reg-email">Email</label>
                            <input type="email" name="email" id="reg-email" class="form-input" placeholder="contoh@email.com" value="{{ old('email') }}" autocomplete="username" required>
                        </div>
                        <div class="form-group">
                            <label for="reg-phone">Nomor WhatsApp</label>
                            <input type="text" name="phone_number" id="reg-phone" class="form-input" placeholder="08XXXXXXXXXX" value="{{ old('phone_number') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="reg-nik">NIK (Nomor Induk Kependudukan)</label>
                            <input type="text" name="nik" id="reg-nik" class="form-input" placeholder="320xxxxxxxxxxxxx" value="{{ old('nik') }}" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="reg-password">Password</label>
                            <input type="password" name="password" id="reg-password" class="form-input" placeholder="Minimal 6 karakter" autocomplete="new-password" required>
                        </div>
                        <div class="form-group">
                            <label for="reg-password-confirm">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="reg-password-confirm" class="form-input" placeholder="Ulangi password" autocomplete="new-password" required>
                        </div>
                        <button type="submit" class="btn-auth-submit">Daftar Akun</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            const tabs = document.querySelectorAll('.auth-tab-title');
            const panels = document.querySelectorAll('.auth-form-panel');
            
            tabs.forEach(t => t.classList.remove('active'));
            panels.forEach(p => p.classList.remove('active'));

            if (tab === 'login') {
                tabs[0].classList.add('active');
                document.getElementById('login-panel').classList.add('active');
            } else {
                tabs[1].classList.add('active');
                document.getElementById('register-panel').classList.add('active');
            }
        }

        // Keep register tab active if registration errors occurred
        @if ($errors->has('name') || $errors->has('phone_number') || $errors->has('nik') || old('phone_number') || old('nik'))
            switchTab('register');
        @endif
    </script>
</body>
</html>
