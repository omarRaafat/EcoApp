<?php

namespace App\Events\Admin\Vendor;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Warning
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $vendorWarning;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($vendorWarning)
    {
        $this->vendorWarning = $vendorWarning;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
