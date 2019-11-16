<?php

namespace giffgaff\StopForumSpam\Listeners;

use Flarum\User\Event\Registered;
use giffgaff\StopForumSpam\Util\Processor;
use Illuminate\Contracts\Events\Dispatcher;

class UserRegistration
{

    private $processor;

    public function __construct(Processor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(Registered::class, [$this, 'userRegistered']);
    }

    /**
     * @param Registered $event
     */
    public function userRegistered(Registered $event):void
    {
        $this->processor->processRegistration($event->user);
    }
}
