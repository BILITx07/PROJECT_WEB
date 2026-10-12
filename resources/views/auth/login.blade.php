<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin – CampRent</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="login-page">

  <!-- Brand -->
  <div class="login-brand">
    <div class="login-tent-icon">
      <!-- Tent SVG matching design (gold/amber tent) -->
      <svg width="72" height="72" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
        <!-- Fire -->
        <ellipse cx="36" cy="28" rx="3" ry="5" fill="#e65100" opacity="0.85"/>
        <ellipse cx="36" cy="26" rx="2" ry="3.5" fill="#ff7043"/>
        <!-- Tent body -->
        <polygon points="8,58 36,14 64,58" fill="#c8a84b"/>
        <polygon points="36,14 64,58 50,58" fill="#a8882a"/>
        <!-- Tent door -->
        <ellipse cx="36" cy="58" rx="8" ry="6" fill="#1a2918"/>
        <!-- Ground line -->
        <line x1="6" y1="60" x2="66" y2="60" stroke="#c8a84b" stroke-width="2" stroke-linecap="round"/>
      </svg>
    </div>
    <h1>CAMPRENT</h1>
    <p>Admin Login</p>
  </div>

  <!-- Card -->
  <div class="login-card">

    @if(session('success'))
      <div class="alert alert-success mb-16">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger mb-16">
        <i class="fa-solid fa-triangle-exclamation"></i> {{ $errors->first() }}
      </div>
    @endif

    <form action="{{ route('login.perform') }}" method="POST">
      @csrf

      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}"
               placeholder="admin@camprent.com" required autofocus>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <div class="input-wrap">
          <input type="password" name="password" id="password"
                 placeholder="••••••••" required>
          <button type="button" class="input-toggle-pw" onclick="togglePw()">
            <i class="fa-regular fa-eye" id="pw-icon"></i>
          </button>
        </div>
      </div>

      <div class="login-extras">
        <label>
          <input type="checkbox" name="remember" style="accent-color:#d4813a;">
          Ingat saya
        </label>
        <a href="#">Lupa Password?</a>
      </div>

      <button type="submit" class="btn-login">Login</button>
    </form>
  </div>

</div>

<script>
  function togglePw() {
    const input = document.getElementById('password');
    const icon  = document.getElementById('pw-icon');
    if (input.type === 'password') {
      input.type = 'text';
      icon.className = 'fa-regular fa-eye-slash';
    } else {
      input.type = 'password';
      icon.className = 'fa-regular fa-eye';
    }
  }
</script>
</body>
</html>
