<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookingCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $bookingCode;
    public $customerName;
    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct($bookingCode, $customerName)
    {
        $this->bookingCode = $bookingCode;
        $this->customerName = $customerName;
        $this->message = "Pesanan baru ($bookingCode) dari $customerName!";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('admin-notifications'),
        ];
    }
    
    /**
     * Tentukan nama event saat disiarkan
     */
    public function broadcastAs()
    {
        return 'BookingCreated';
    }
}
