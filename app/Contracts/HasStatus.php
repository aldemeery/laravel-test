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
}
