<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PublishData implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public String $message, public String $topic)
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new PrivateChannel($this->topic);
        // return [
        //     // new PrivateChannel($this->topic),
        //     // new Channel($this->topic)
        // ];
    }

    public function broadcastAs()
    {
        return 'PublishData';
    }

    public function broadcastWith()
    {
        // Ensure the data is correctly structured
        return [
            'voltage' => 330,
            'current' => 460,
            'status' => true
        ];
    }

}
