<?php

namespace App\Listeners;

use App\Events\ModelDisqualified;
use App\Models\Comment;
use App\Models\Post;
use App\Notifications\CommentRejected;
use App\Notifications\PostRejected;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendRejectionNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ModelDisqualified  $event
     * @return void
     */
    public function handle(ModelDisqualified $event)
    {
        $model = $event->getModel();
        $class = get_class($model);

        if ($this->supportsRejectionNotifications($class)) {
            $user = $model->user;
            $notification = $this->getNotification($class);

            $user->notify(new $notification($model));
        }
    }

    /**
     * Get the notification class for a given model class.
     *
     *  @param string $class Model class.
     *
     * @return string
     */
    private function getNotification(string $class): string
    {
        return $this->notificationMap()[$class];
    }

    /**
     * Get the model/notification map.
     *
     * @return array
     */
    private function notificationMap(): array
    {
        return [
            Post::class => PostRejected::class,
            Comment::class => CommentRejected::class,
        ];
    }

    /**
     * Determine whether rejection notifications are supported for a given model class.
     *
     *  @param string $class Model class.
     *
     * @return bool
     */
    private function supportsRejectionNotifications(string $class): bool
    {
        return in_array($class, array_keys($this->notificationMap()));
    }
}
