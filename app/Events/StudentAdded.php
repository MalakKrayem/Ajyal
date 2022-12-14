<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StudentAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $studentGroup;
    public $group_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($studentGroup,$group_id)
    {
        //
        $this->studentGroup= $studentGroup;
        $this->group_id=$group_id;
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