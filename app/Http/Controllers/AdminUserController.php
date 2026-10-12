<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminUserController extends Controller
{
    public function index()
    {
        // Ambil semua pengguna dengan role 'user' (bukan admin) 
        // beserta jumlah total booking dan jumlah booking yang aktif (belum selesai/dibatalkan)
        $users = User::where('role', 'user')
                    ->withCount(['bookings', 'bookings as active_bookings' => function($q) {
                        $q->whereIn('status', ['PENDING', 'Dikonfirmasi']);
                    }])
                    ->latest()
                    ->get();
                    
        return view('admin.users', compact('users'));
    }
}
