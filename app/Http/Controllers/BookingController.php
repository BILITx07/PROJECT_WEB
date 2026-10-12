<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\Item;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        // 1. Jalankan Auto-Cancel untuk pesanan COD yang kadaluwarsa (lewat 6 jam)
        Booking::autoCancelExpiredCodBookings();

        $query = Booking::with('bookingItems.item')->latest();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('customer_name', 'like', '%' . $request->search . '%')
                  ->orWhere('booking_code', 'like', '%' . $request->search . '%');
            });
        }

        // Default tab adalah menunggu_transfer
        $statusTab = $request->status ?? 'menunggu_transfer';

        if ($statusTab === 'menunggu_transfer') {
            $query->where('status', 'menunggu')
                  ->where('payment_method', '!=', 'cod')
                  ->whereNotNull('payment_proof');
        } elseif ($statusTab === 'menunggu_cod') {
            $query->where('status', 'menunggu')
                  ->where('payment_method', 'cod');
        } elseif ($statusTab === 'riwayat') {
            $query->whereIn('status', ['dikonfirmasi', 'sedang_disewa', 'selesai', 'dibatalkan']);
        }

        $bookings = $query->get();
        $items    = Item::where('stock', '>', 0)->get();

        return view('admin.bookings', compact('bookings', 'items', 'statusTab'));
    }

    public function show(Booking $booking)
    {
        $booking->load('bookingItems.item');
        return view('admin.booking-detail', compact('booking'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'phone_number'  => ['nullable', 'string', 'max:20'],
            'item_ids'      => ['required', 'array', 'min:1'],
            'item_ids.*'    => ['exists:items,id'],
            'quantities'    => ['required', 'array'],
            'quantities.*'  => ['integer', 'min:1'],
            'start_date'    => ['required', 'date'],
            'end_date'      => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        $start = Carbon::parse($validated['start_date']);
        $end   = Carbon::parse($validated['end_date']);
        $days  = max(1, $start->diffInDays($end));

        $totalPrice = 0;
        $itemLines  = [];

        foreach ($validated['item_ids'] as $i => $itemId) {
            $item = Item::findOrFail($itemId);
            $qty  = $validated['quantities'][$i] ?? 1;
            $totalPrice += $item->price_per_day * $qty * $days;
            $itemLines[] = ['item' => $item, 'qty' => $qty];
        }

        $booking = Booking::create([
            'booking_code'  => Booking::generateCode(),
            'customer_name' => $validated['customer_name'],
            'phone_number'  => $validated['phone_number'] ?? null,
            'start_date'    => $validated['start_date'],
            'end_date'      => $validated['end_date'],
            'total_price'   => $totalPrice,
            'status'        => 'menunggu',
        ]);

        foreach ($itemLines as $line) {
            BookingItem::create([
                'booking_id'   => $booking->id,
                'item_id'      => $line['item']->id,
                'quantity'     => $line['qty'],
                'price_per_day'=> $line['item']->price_per_day,
            ]);
        }

        return redirect()->route('admin.bookings.index')
                         ->with('success', 'Booking ' . $booking->booking_code . ' berhasil ditambahkan!');
    }

    public function confirm(Booking $booking)
    {
        if ($booking->status !== 'menunggu') {
            return redirect()->route('admin.bookings.index')
                             ->with('error', 'Hanya booking berstatus Menunggu yang dapat dikonfirmasi.');
        }

        // Check and deduct stock for each item
        foreach ($booking->bookingItems as $bi) {
            if ($bi->item->stock < $bi->quantity) {
                return redirect()->route('admin.bookings.index')
                                 ->with('error', 'Stok ' . $bi->item->name . ' tidak mencukupi.');
            }
        }

        foreach ($booking->bookingItems as $bi) {
            $bi->item->decrement('stock', $bi->quantity);
        }

        $booking->update(['status' => 'dikonfirmasi']);

        return redirect()->back()
                         ->with('success', 'Booking ' . $booking->booking_code . ' berhasil dikonfirmasi!');
    }

    public function pickup(Booking $booking)
    {
        if ($booking->status !== 'dikonfirmasi') {
            return redirect()->back()
                             ->with('error', 'Hanya booking berstatus Dikonfirmasi yang dapat diserahkan ke penyewa.');
        }

        $booking->update(['status' => 'sedang_disewa']);

        return redirect()->back()
                         ->with('success', 'Barang pada booking ' . $booking->booking_code . ' telah diserahkan dan kini sedang disewa.');
    }

    public function complete(Booking $booking)
    {
        if ($booking->status !== 'dikonfirmasi' && $booking->status !== 'sedang_disewa') {
            return redirect()->back()
                             ->with('error', 'Hanya booking berstatus Dikonfirmasi atau Sedang Disewa yang dapat diselesaikan.');
        }

        // Restore stock
        foreach ($booking->bookingItems as $bi) {
            $bi->item->increment('stock', $bi->quantity);
        }

        $booking->update(['status' => 'selesai']);

        return redirect()->back()
                         ->with('success', 'Booking ' . $booking->booking_code . ' telah diselesaikan dan barang dikembalikan.');
    }

    public function cancel(Booking $booking)
    {
        if (in_array($booking->status, ['selesai', 'dibatalkan'])) {
            return redirect()->back()
                             ->with('error', 'Booking ini tidak dapat dibatalkan.');
        }

        // Restore stock if was already confirmed or rented
        if (in_array($booking->status, ['dikonfirmasi', 'sedang_disewa'])) {
            foreach ($booking->bookingItems as $bi) {
                $bi->item->increment('stock', $bi->quantity);
            }
        }

        $booking->update(['status' => 'dibatalkan']);

        return redirect()->back()
                         ->with('success', 'Booking ' . $booking->booking_code . ' telah dibatalkan.');
    }
}
