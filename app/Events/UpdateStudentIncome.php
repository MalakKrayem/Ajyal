<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateStudentIncome
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $salary;
    public $student;
    public $old_salary;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($salary,$student,$old_salary)
    {
        $this->salary = $salary;
        $this->student = $student;
        $this->old_salary = $old_salary;
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
