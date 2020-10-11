<?php

namespace App\Events;

use App\Contracts\Moderated;
use App\Models\Post;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ModeratedModelCreated
{
    use Dispatchable, SerializesModels;

    /**
     * Moderated model instance.
     *
     * @var \App\Contracts\Moderated
     */
    private $model;

    /**
     * Create a new event instance.
     *
     * @param \App\Contracts\Moderated $model Moderated model instance.
     *
     * @return void
     */
    public function __construct(Moderated $model)
    {
        $this->model = $model;
    }

    /**
     * Get the model of this event.
     *
     * @return \App\Contracts\Moderated
     */
    public function getModel(): Moderated
    {
        return $this->model;
    }
}
