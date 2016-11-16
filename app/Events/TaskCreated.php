<?php

namespace App\Events;

use App\Events\Event;
use App\Task;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TaskCreated extends Event
{
    use SerializesModels;

    public $receivers;
    public $sender;
    public $task;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($sender, Task $task, $receivers)
    {
        $this->receivers=$receivers;
        $this->sender=$sender;
        $this->task=$task;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
