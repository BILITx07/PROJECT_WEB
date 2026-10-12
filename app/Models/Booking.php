<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'customer_name',
        'phone_number',
        'start_date',
        'end_date',
        'total_price',
        'status',
        'payment_method',
        'payment_proof',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function bookingItems()
    {
        return $this->hasMany(BookingItem::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'booking_items')
                    ->withPivot('quantity', 'price_per_day')
                    ->withTimestamps();
    }

    public static function generateCode(): string
    {
        $latest = static::latest()->first();
        $nextNum = $latest ? ($latest->id + 1) : 1;
        return 'CR-' . str_pad(300000 + $nextNum, 6, '0', STR_PAD_LEFT);
    }

    public function getDurationAttribute(): int
    {
        return max(1, $this->start_date->diffInDays($this->end_date));
    }

    /**
     * Otomatis membatalkan pesanan COD yang sudah lebih dari 6 jam menunggu.
     */
    public static function autoCancelExpiredCodBookings(): void
    {
        $expiredTime = now()->subHours(6);
        
        static::where('payment_method', 'cod')
              ->where('status', 'menunggu')
              ->where('created_at', '<', $expiredTime)
              ->update(['status' => 'dibatalkan']);
    }
}

