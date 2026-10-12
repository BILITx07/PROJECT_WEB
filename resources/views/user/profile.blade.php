@extends('layouts.user')

@section('title', 'Profil Saya - CampRent')

@section('content')
<div class="profile-wrapper">
    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-header-icon">
                <i class="fa-solid fa-user"></i>
            </div>
            <div>
                <h2 class="profile-header-title">Profil Saya</h2>
                <p class="profile-header-subtitle">Kelola informasi akun Anda di sini</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger" style="margin-bottom: 1.5rem;">
                <ul style="list-style: none; margin: 0; padding: 0;">
                    @foreach ($errors->all() as $error)
                        <li><i class="fa-solid fa-circle-xmark"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group" style="margin-bottom: 1.25rem;">
                <label for="name">Nama Lengkap</label>
                <input type="text" name="name" id="name" class="form-input" value="{{ old('name', $user->name) }}" placeholder="Masukkan nama lengkap Anda" required>
            </div>

            <div class="form-group" style="margin-bottom: 1.25rem;">
                <label for="email">Alamat Email</label>
                <input type="email" name="email" id="email" class="form-input" value="{{ old('email', $user->email) }}" placeholder="contoh@email.com" required>
            </div>

            <div class="form-group" style="margin-bottom: 1.25rem;">
                <label for="phone_number">Nomor WhatsApp</label>
                <input type="text" name="phone_number" id="phone_number" class="form-input" value="{{ old('phone_number', $user->phone_number) }}" placeholder="Masukkan nomor WhatsApp Anda" required>
            </div>

            <div class="form-group" style="margin-bottom: 1.25rem;">
                <label for="nik">NIK (Nomor Induk Kependudukan)</label>
                <input type="text" name="nik" id="nik" class="form-input" value="{{ old('nik', $user->nik) }}" placeholder="Masukkan NIK Anda" required>
            </div>

            <div class="profile-password-section">
                <p class="profile-password-section-title">
                    <i class="fa-solid fa-key"></i> Ubah Password (Kosongkan jika tidak ingin diubah)
                </p>
                
                <div class="form-group" style="margin-bottom: 0.75rem;">
                    <label for="password">Password Baru</label>
                    <input type="password" name="password" id="password" class="form-input" placeholder="Minimal 6 karakter" autocomplete="new-password">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" placeholder="Ulangi password baru" autocomplete="new-password">
                </div>
            </div>

            <div class="profile-actions">
                <a href="{{ route('user.dashboard') }}" class="btn-profile-cancel">Kembali</a>
                <button type="submit" class="btn-profile-save">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
