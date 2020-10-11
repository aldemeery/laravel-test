<?php

namespace App\Contracts;

interface HasStatus
{
    /**
     * Get a value representing the "Approved" status.
     *
     * @return mixed
     */
    public function getApprovedStatus();

    /**
     * Approve this model.
     *
     * @return self
     */
    public function approve(): self;

    /**
     * Reject this model.
     *
     * @return self
     */
    public function reject(): self;
}
