<?php

namespace App\Jobs;

use App\Contracts\Moderated;
use App\Events\ModelDisqualified;
use App\Events\ModelQualified;
use App\Services\TextModerator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ModerateText implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Model to modrate.
     *
     * @var \App\Contracts\Moderated
     */
    private $model;

    /**
     * Text moderator service instance.
     *
     * @var \App\Services\TextModerator
     */
    private $textModerator;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Moderated $model, TextModerator $textModerator)
    {
        $this->model = $model;
        $this->textModerator = $textModerator;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $qualified = $this->textModerator->check($this->model->getModerationText());

        $qualified ? event(new ModelQualified($this->model)) : event(new ModelDisqualified($this->model));
    }
}
