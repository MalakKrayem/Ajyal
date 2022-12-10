<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateStudentRate
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $student;
    public $old_rate;
    public $new_rate;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($student,$old_rate,$new_rate)
    {
        $this->student=$student;
        $this->old_rate=$old_rate;
        $this->new_rate=$new_rate;
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