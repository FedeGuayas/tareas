<?php

namespace App\Listeners;

use App\Events\TaskFinished;
use App\Http\Controllers\TaskController;
use App\User;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EndTaskNotificationEmail
{
    protected $mailer;
    protected $end_task;
    protected $receivers;
    
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Mailer $mailer, TaskController $end_task, User $receivers)
    {
        $this->mailer=$mailer;
        $this->end_task=$end_task;
        $this->receivers=$receivers;
    }

    /**
     * Handle the event.
     *
     * @param  TaskFinished  $event
     * @return void
     */
    public function handle(TaskFinished $event)
    {
        $this->end_task->sendEndTaskMail($event->sender,$event->task,$event->receivers);
    }
}
