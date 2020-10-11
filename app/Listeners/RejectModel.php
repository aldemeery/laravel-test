<?php

namespace App\Listeners;

use App\Events\ModelDisqualified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RejectModel
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
     * @param \App\Events\ModelDisqualified  $event
     * @return void
     */
    public function handle(ModelDisqualified $event)
    {
        $model = $event->getModel();
        $model->reject();
    }
}
