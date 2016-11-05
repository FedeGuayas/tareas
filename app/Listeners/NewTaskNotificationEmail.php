<?php

namespace App\Listeners;

use App\Events\TaskCreated;
use App\Http\Controllers\TaskController;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewTaskNotificationEmail implements ShouldQueue
{
    protected $mailer;
    protected $new_task;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Mailer $mailer, TaskController $new_task)
    {
        $this->mailer=$mailer;
        $this->new_task=$new_task;
    }

    /**
     * Handle the event.
     *
     * @param  TaskCreated  $event
     * @return void
     */
    public function handle(TaskCreated $event)
    {
        $this->new_task->sendNewTaskMail($event->sender,$event->task);


    }
}
