<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'stock',
        'price_per_day',
        'image',
        'description',
    ];

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_items')
                    ->withPivot('quantity', 'price_per_day')
                    ->withTimestamps();
    }

    public function bookingItems()
    {
        return $this->hasMany(BookingItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
}
