<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon;

class UserBookingController extends Controller
{
    public function history()
    {
        // Jalankan Auto-Cancel
        Booking::autoCancelExpiredCodBookings();

        $user = auth()->user();
        
        // Match bookings by customer's phone number
        $bookings = Booking::where('phone_number', $user->phone_number)
            ->with('items')
            ->orderBy('created_at', 'desc')
            ->get();

        $cartCount = $user->cartItems()->sum('quantity');

        return view('user.bookings', compact('bookings', 'cartCount'));
    }

    public function receipt($bookingCode)
    {
        $user = auth()->user();
        
        $booking = Booking::where('booking_code', $bookingCode)
            ->with('bookingItems.item')
            ->firstOrFail();

        // Security check: ensure the booking belongs to this user
        if ($booking->phone_number !== $user->phone_number) {
            abort(403, 'Akses ditolak. Struk ini bukan milik Anda.');
        }

        // Format dates
        $startDateFormatted = Carbon::parse($booking->start_date)->translatedFormat('d F Y');
        $endDateFormatted = Carbon::parse($booking->end_date)->translatedFormat('d F Y');
        $rentalPeriod = $startDateFormatted . ' - ' . $endDateFormatted;

        $duration = Carbon::parse($booking->start_date)->diffInDays(Carbon::parse($booking->end_date));
        if ($duration <= 0) {
            $duration = 1;
        }

        return view('user.receipt', compact('booking', 'rentalPeriod', 'duration'));
    }

    public function cancel($bookingCode)
    {
        $user = auth()->user();
        
        $booking = Booking::where('booking_code', $bookingCode)
            ->with('bookingItems.item')
            ->firstOrFail();

        // Security check: ensure the booking belongs to this user
        if ($booking->phone_number !== $user->phone_number) {
            abort(403, 'Akses ditolak.');
        }

        // Only allow cancel if waiting
        if ($booking->status !== 'menunggu') {
            return redirect()->back()->with('error', 'Pesanan ini sudah tidak dapat dibatalkan karena sedang diproses.');
        }

        // Restore stock
        foreach ($booking->bookingItems as $bi) {
            if ($bi->item) {
                $bi->item->increment('stock', $bi->quantity);
            }
        }

        $booking->update(['status' => 'dibatalkan']);

        return redirect()->back()->with('success', 'Pesanan ' . $booking->booking_code . ' berhasil dibatalkan dan stok dikembalikan.');
    }
}
