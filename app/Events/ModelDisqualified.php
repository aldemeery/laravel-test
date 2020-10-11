<?php

namespace App\Events;

use App\Contracts\HasStatus;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ModelDisqualified
{
    use Dispatchable, SerializesModels;

    /**
     * Disqualified model.
     *
     * @var \App\Contracts\HasStatus
     */
    private $model;

    /**
     * Create a new event instance.
     *
     * @param \App\Contracts\HasStatus $model Disqualified model.
     *
     * @return void
     */
    public function __construct(HasStatus $model)
    {
        $this->model = $model;
    }

    /**
     * Get the disqualified model.
     *
     * @return \App\Contracts\HasStatus
     */
    public function getModel(): HasStatus
    {
        return $this->model;
    }
}
