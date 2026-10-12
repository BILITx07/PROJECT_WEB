@extends('layouts.admin')

@section('title', 'Data Pengguna')

@section('content')

<div class="page-header" style="margin-bottom: 1.5rem;">
  <div>
    <h2 style="font-size: 1.6rem; font-weight: 800; color: #1F2E26; font-family: 'Outfit', sans-serif;">Data Pengguna</h2>
    <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 0.15rem;">Daftar semua pengguna yang terdaftar di sistem</p>
  </div>
</div>

<div class="table-responsive-admin" style="background: #FFF; border-radius: 12px; border: 1px solid #ECE7DD; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
  <table class="table-admin" style="width: 100%; border-collapse: collapse;">
    <thead>
      <tr>
        <th style="width: 30%;">Pengguna</th>
        <th style="width: 25%;">Kontak</th>
        <th style="width: 20%; text-align: center;">Total Booking</th>
        <th style="width: 25%;">Status Booking</th>
      </tr>
    </thead>
    <tbody>
      @forelse($users as $user)
        <tr>
          <td>
            <div style="display: flex; align-items: center; gap: 1rem;">
              <div style="width: 40px; height: 40px; border-radius: 50%; background: #FAF6EC; display: flex; align-items: center; justify-content: center; color: #0C2D1C; font-weight: 700; font-size: 1.1rem; flex-shrink: 0;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
              </div>
              <div>
                <span style="font-weight: 600; color: #1F2E26; font-size: 0.95rem; display: block;">{{ $user->name }}</span>
                <span style="font-size: 0.8rem; color: var(--text-muted);">Terdaftar: {{ $user->created_at->format('d M Y') }}</span>
              </div>
            </div>
          </td>
          <td>
            <div style="font-size: 0.9rem; color: #1F2E26; margin-bottom: 0.2rem;"><i class="fa-solid fa-envelope" style="color: #A0B0A8; width: 16px;"></i> {{ $user->email }}</div>
            <div style="font-size: 0.9rem; color: #1F2E26;"><i class="fa-solid fa-phone" style="color: #A0B0A8; width: 16px;"></i> {{ $user->phone_number ?? '-' }}</div>
          </td>
          <td style="text-align: center;">
            <span style="font-weight: 700; color: #1F2E26; font-size: 1.1rem;">{{ $user->bookings_count }}</span>
          </td>
          <td>
            @if($user->active_bookings > 0)
              <span class="badge-status status-diproses" style="background: rgba(255, 122, 0, 0.1); color: #FF7A00; padding: 6px 12px; border-radius: 6px; font-size: 0.8rem; font-weight: 600;">
                <i class="fa-solid fa-clock-rotate-left"></i> {{ $user->active_bookings }} Aktif
              </span>
            @else
              <span class="badge-status" style="background: #F1F5F3; color: #6B7C73; padding: 6px 12px; border-radius: 6px; font-size: 0.8rem; font-weight: 600;">
                Tidak ada booking aktif
              </span>
            @endif
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="4" style="padding: 3rem; text-align: center;">
            <div class="empty-state">
              <i class="fa-solid fa-users-slash" style="font-size: 2.5rem; color: var(--text-muted); margin-bottom: 0.75rem;"></i>
              <p style="color: var(--text-muted); font-size: 0.95rem;">Belum ada pengguna yang mendaftar.</p>
            </div>
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

@endsection
