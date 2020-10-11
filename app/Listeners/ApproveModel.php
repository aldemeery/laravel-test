<?php

namespace App\Listeners;

use App\Events\ModelQualified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ApproveModel
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
     * @param \App\Events\ModelQualified  $event
     * @return void
     */
    public function handle(ModelQualified $event)
    {
        $model = $event->getModel();
        $model->approve();
    }
}
