<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Item;
use App\Models\Booking;
use App\Models\BookingItem;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ── Admin User ──────────────────────────────────────────────
        User::create([
            'name'     => 'Admin CampRent',
            'email'    => 'admin@camprent.com',
            'password' => Hash::make('password123'),
        ]);

        // ── Items (Data Barang) ──────────────────────────────────────
        $t56 = Item::create([
            'name'          => 'Tenda (kap 5-6)',
            'category'      => 'Tenda',
            'stock'         => 3,
            'price_per_day' => 40000,
        ]);
        $t45 = Item::create([
            'name'          => 'Tenda (kap 4-5)',
            'category'      => 'Tenda',
            'stock'         => 3,
            'price_per_day' => 35000,
        ]);
        $t34 = Item::create([
            'name'          => 'Tenda (kap 3-4)',
            'category'      => 'Tenda',
            'stock'         => 3,
            'price_per_day' => 30000,
        ]);
        $t23 = Item::create([
            'name'          => 'Tenda (kap 2-3)',
            'category'      => 'Tenda',
            'stock'         => 3,
            'price_per_day' => 25000,
        ]);
        $tul = Item::create([
            'name'          => 'Tenda Ultralight (kap 1-2)',
            'category'      => 'Tenda',
            'stock'         => 3,
            'price_per_day' => 25000,
        ]);
        $tg60 = Item::create([
            'name'          => 'Tas Gunung (60L)',
            'category'      => 'Tas',
            'stock'         => 3,
            'price_per_day' => 25000,
        ]);
        $tg45 = Item::create([
            'name'          => 'Tas Gunung (45L)',
            'category'      => 'Tas',
            'stock'         => 3,
            'price_per_day' => 20000,
        ]);
        $kompor = Item::create([
            'name'          => 'Kompor Portable (kotak & bunga)',
            'category'      => 'Alat Masak',
            'stock'         => 5,
            'price_per_day' => 8000,
        ]);
        $sb = Item::create([
            'name'          => 'Sleeping Bag Polar',
            'category'      => 'Perlengkapan',
            'stock'         => 5,
            'price_per_day' => 10000,
        ]);

        // ── Bookings ────────────────────────────────────────────────
        // CR-311225 – Jimi – Menunggu – Rp 66.000
        // Items: Tenda Ultralight (25k) + Kompor (8k) × 2 hari = (25k+8k)×2=66k
        $b1 = Booking::create([
            'booking_code'  => 'CR-311225',
            'customer_name' => 'Jimi',
            'phone_number'  => '08124546667',
            'start_date'    => '2026-07-10',
            'end_date'      => '2026-07-12',
            'total_price'   => 66000,
            'status'        => 'menunggu',
        ]);
        BookingItem::create(['booking_id' => $b1->id, 'item_id' => $tul->id, 'quantity' => 1, 'price_per_day' => 25000]);
        BookingItem::create(['booking_id' => $b1->id, 'item_id' => $kompor->id, 'quantity' => 1, 'price_per_day' => 8000]);

        // CR-311224 – Billi – Dikonfirmasi – Rp 25.000
        $b2 = Booking::create([
            'booking_code'  => 'CR-311224',
            'customer_name' => 'Billi',
            'phone_number'  => '08133344456',
            'start_date'    => '2026-07-09',
            'end_date'      => '2026-07-10',
            'total_price'   => 25000,
            'status'        => 'dikonfirmasi',
        ]);
        BookingItem::create(['booking_id' => $b2->id, 'item_id' => $tul->id, 'quantity' => 1, 'price_per_day' => 25000]);

        // CR-311223 – Dinar – Menunggu – Rp 50.000
        $b3 = Booking::create([
            'booking_code'  => 'CR-311223',
            'customer_name' => 'Dinar',
            'phone_number'  => '08122234567',
            'start_date'    => '2026-07-09',
            'end_date'      => '2026-07-11',
            'total_price'   => 50000,
            'status'        => 'menunggu',
        ]);
        BookingItem::create(['booking_id' => $b3->id, 'item_id' => $t23->id, 'quantity' => 1, 'price_per_day' => 25000]);

        // CR-311222 – Yusril – Dikonfirmasi – Rp 80.000
        $b4 = Booking::create([
            'booking_code'  => 'CR-311222',
            'customer_name' => 'Yusril',
            'phone_number'  => '08100987654',
            'start_date'    => '2026-07-09',
            'end_date'      => '2026-07-11',
            'total_price'   => 80000,
            'status'        => 'dikonfirmasi',
        ]);
        BookingItem::create(['booking_id' => $b4->id, 'item_id' => $t34->id, 'quantity' => 1, 'price_per_day' => 30000]);
        BookingItem::create(['booking_id' => $b4->id, 'item_id' => $tg45->id, 'quantity' => 1, 'price_per_day' => 10000]);

        // CR-311221 – Doni – Dibatalkan – Rp 20.000
        $b5 = Booking::create([
            'booking_code'  => 'CR-311221',
            'customer_name' => 'Doni',
            'phone_number'  => '08111112222',
            'start_date'    => '2026-07-09',
            'end_date'      => '2026-07-10',
            'total_price'   => 20000,
            'status'        => 'dibatalkan',
        ]);
        BookingItem::create(['booking_id' => $b5->id, 'item_id' => $tg45->id, 'quantity' => 1, 'price_per_day' => 20000]);

        // CR-311220 – Fitri – Selesai – Rp 32.000
        $b6 = Booking::create([
            'booking_code'  => 'CR-311220',
            'customer_name' => 'Fitri',
            'phone_number'  => '08555667788',
            'start_date'    => '2026-07-06',
            'end_date'      => '2026-07-10',
            'total_price'   => 32000,
            'status'        => 'selesai',
        ]);
        BookingItem::create(['booking_id' => $b6->id, 'item_id' => $sb->id, 'quantity' => 1, 'price_per_day' => 8000]);
    }
}
