<?php

namespace App\Contracts;

interface Moderated
{
    /**
     * Get the text used for moderation.
     *
     * @return string
     */
    public function getModerationText(): string;
}
