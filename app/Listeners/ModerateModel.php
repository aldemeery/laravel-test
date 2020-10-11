<?php

namespace App\Listeners;

use App\Events\ModeratedModelCreated;
use App\Jobs\ModerateText;
use App\Services\TextModerator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ModerateModel
{
    /**
     * Text moderator service instance.
     *
     * @var \App\Services\TextModerator
     */
    private $textModerator;

    /**
     * Create the event listener.
     *
     * @param \App\Services\TextModerator $textModerator
     *
     * @return void
     */
    public function __construct(TextModerator $textModerator)
    {
        $this->textModerator = $textModerator;
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\ModeratedModelCreated $event Event instance.
     *
     * @return void
     */
    public function handle(ModeratedModelCreated $event)
    {
        ModerateText::dispatch($event->getModel(), $this->textModerator);
    }
}
