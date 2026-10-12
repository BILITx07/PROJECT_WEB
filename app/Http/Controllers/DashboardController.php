<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBookings   = Booking::count();
        $todayBookings   = Booking::whereDate('created_at', today())->count();
        $totalPendapatan = Booking::whereIn('status', ['dikonfirmasi', 'selesai'])->sum('total_price');
        $barangTersedia  = Item::sum('stock');

        $recentBookings = Booking::with('bookingItems.item')
            ->latest()
            ->take(6)
            ->get();

        return view('admin.dashboard', compact(
            'totalBookings',
            'todayBookings',
            'totalPendapatan',
            'barangTersedia',
            'recentBookings'
        ));
    }
}
