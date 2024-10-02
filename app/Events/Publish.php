<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Publish implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $channelName;
    public $data;

    /**
     * Create a new event instance.
     */
    public function __construct($channelName, $data)
    {
        $this->channelName = $channelName;
        $this->data = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new PrivateChannel($this->channelName);
        // return [
        //     new PrivateChannel('omokugs-pv'),
        //     new PrivateChannel('eerc_disco_street-transformer_newHaven_assembly')
        // ];
    }

    public function broadcastAs()
    {
        return 'Publish';
    }

}
