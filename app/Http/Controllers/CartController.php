<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Item;
use App\Models\Booking;
use App\Models\BookingItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\Events\BookingCreated;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = auth()->user()->cartItems()->with('item')->get();

        // Retrieve dates from session or default
        $startDate = session('rental_start_date', Carbon::tomorrow()->format('Y-m-d'));
        $endDate = session('rental_end_date', Carbon::tomorrow()->addDays(2)->format('Y-m-d'));

        // Calculate duration
        $duration = 1;
        try {
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $duration = $start->diffInDays($end);
            if ($duration <= 0) {
                $duration = 1;
            }
        } catch (\Exception $e) {}

        // Calculate total
        $totalPrice = 0;
        foreach ($cartItems as $cartItem) {
            $totalPrice += $cartItem->item->price_per_day * $cartItem->quantity * $duration;
        }

        return view('user.cart', compact('cartItems', 'startDate', 'endDate', 'duration', 'totalPrice'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'integer|min:1',
            'redirect' => 'string' // 'cart' or 'dashboard'
        ]);

        $item = Item::findOrFail($request->item_id);
        $quantity = $request->get('quantity', 1);

        // Check stock availability
        if ($item->stock <= 0) {
            return back()->with('error', 'Barang ini sedang habis stok.');
        }

        $cartItem = auth()->user()->cartItems()->where('item_id', $item->id)->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;
            if ($newQuantity > $item->stock) {
                $cartItem->quantity = $item->stock;
                $cartItem->save();
                return back()->with('warning', 'Jumlah barang disesuaikan dengan stok maksimal yang tersedia (' . $item->stock . ').');
            }
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        } else {
            if ($quantity > $item->stock) {
                $quantity = $item->stock;
            }
            auth()->user()->cartItems()->create([
                'item_id' => $item->id,
                'quantity' => $quantity
            ]);
        }

        if ($request->redirect === 'cart') {
            return redirect()->route('user.cart');
        }

        return back()->with('success', 'Barang berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, Cart $cart)
    {
        // Ensure cart belongs to authenticated user
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'action' => 'required|in:increase,decrease',
        ]);

        $item = $cart->item;

        if ($request->action === 'increase') {
            if ($cart->quantity + 1 > $item->stock) {
                return back()->with('error', 'Stok tidak mencukupi. Stok maksimal: ' . $item->stock);
            }
            $cart->quantity += 1;
            $cart->save();
        } elseif ($request->action === 'decrease') {
            if ($cart->quantity - 1 >= 1) {
                $cart->quantity -= 1;
                $cart->save();
            } else {
                $cart->delete();
                return back()->with('success', 'Barang dihapus dari keranjang.');
            }
        }

        return back();
    }

    public function remove(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cart->delete();
        return back()->with('success', 'Barang berhasil dihapus dari keranjang.');
    }

    public function updateDates(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ], [
            'start_date.after_or_equal' => 'Tanggal pinjam minimal hari ini.',
            'end_date.after' => 'Tanggal kembali harus setelah tanggal pinjam.',
        ]);

        session([
            'rental_start_date' => $request->start_date,
            'rental_end_date' => $request->end_date,
        ]);

        return back()->with('success', 'Periode sewa berhasil diupdate.');
    }

    public function checkout()
    {
        $cartItems = auth()->user()->cartItems()->with('item')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('user.dashboard')->with('error', 'Keranjang Anda kosong.');
        }

        $startDate = session('rental_start_date', Carbon::tomorrow()->format('Y-m-d'));
        $endDate = session('rental_end_date', Carbon::tomorrow()->addDays(2)->format('Y-m-d'));

        // Recalculate duration
        $duration = 1;
        try {
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $duration = $start->diffInDays($end);
            if ($duration <= 0) {
                $duration = 1;
            }
        } catch (\Exception $e) {}

        // Calculate total
        $totalPrice = 0;
        foreach ($cartItems as $cartItem) {
            // Validate stock at checkout
            if ($cartItem->quantity > $cartItem->item->stock) {
                // Adjust quantity to available stock
                if ($cartItem->item->stock <= 0) {
                    $cartItem->delete();
                    return redirect()->route('user.cart')->with('error', 'Beberapa barang di keranjang Anda kehabisan stok dan telah dihapus.');
                } else {
                    $cartItem->quantity = $cartItem->item->stock;
                    $cartItem->save();
                    return redirect()->route('user.cart')->with('warning', 'Jumlah barang ' . $cartItem->item->name . ' disesuaikan karena keterbatasan stok.');
                }
            }
            $totalPrice += $cartItem->item->price_per_day * $cartItem->quantity * $duration;
        }

        return view('user.checkout', compact('cartItems', 'startDate', 'endDate', 'duration', 'totalPrice'));
    }

    public function processBooking(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:qris,transfer_bca,transfer_mandiri,cod',
            'payment_proof' => 'required_unless:payment_method,cod|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'payment_method.required' => 'Silakan pilih metode pembayaran.',
            'payment_method.in' => 'Metode pembayaran tidak valid.',
            'payment_proof.required_unless' => 'Bukti pembayaran wajib diunggah untuk metode ini.',
            'payment_proof.image' => 'File harus berupa gambar.',
            'payment_proof.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $user = auth()->user();
        $cartItems = $user->cartItems()->with('item')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.dashboard')->with('error', 'Keranjang kosong.');
        }

        $startDate = session('rental_start_date', Carbon::tomorrow()->format('Y-m-d'));
        $endDate = session('rental_end_date', Carbon::tomorrow()->addDays(2)->format('Y-m-d'));

        // Calculate duration
        $duration = 1;
        try {
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $duration = $start->diffInDays($end);
            if ($duration <= 0) {
                $duration = 1;
            }
        } catch (\Exception $e) {}

        // Validate stock one more time
        $totalPrice = 0;
        foreach ($cartItems as $cartItem) {
            if ($cartItem->quantity > $cartItem->item->stock) {
                return redirect()->route('user.cart')->with('error', 'Stok barang ' . $cartItem->item->name . ' tidak mencukupi untuk melakukan checkout.');
            }
            $totalPrice += $cartItem->item->price_per_day * $cartItem->quantity * $duration;
        }

        // Generate booking code
        $bookingCode = Booking::generateCode();

        // Handle File Upload
        $paymentProofPath = null;
        if ($request->hasFile('payment_proof')) {
            $paymentProofPath = $request->file('payment_proof')->store('payments', 'public');
        }

        // Create the booking
        $booking = Booking::create([
            'booking_code' => $bookingCode,
            'customer_name' => $user->name,
            'phone_number' => $user->phone_number,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_price' => $totalPrice,
            'status' => 'menunggu',
            'payment_method' => $request->payment_method,
            'payment_proof' => $paymentProofPath,
        ]);

        // Create booking items & decrement stock
        foreach ($cartItems as $cartItem) {
            BookingItem::create([
                'booking_id' => $booking->id,
                'item_id' => $cartItem->item_id,
                'quantity' => $cartItem->quantity,
                'price_per_day' => $cartItem->item->price_per_day,
            ]);

            // Decrement item stock
            $item = $cartItem->item;
            $item->stock -= $cartItem->quantity;
            $item->save();
        }

        // Empty the cart
        $user->cartItems()->delete();

        // Broadcast event to Pusher
        try {
            event(new BookingCreated($booking->booking_code, $user->name));
        } catch (\Exception $e) {
            \Log::error('Pusher Broadcast Error: ' . $e->getMessage());
        }

        return redirect()->route('user.receipt', $booking->booking_code)->with('booking_success', true);
    }
}
