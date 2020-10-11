<?php

namespace App\Scopes;

use App\Contracts\HasStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class Approved implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder Builder instance.
     * @param \Illuminate\Database\Eloquent\Model   $model   Model instance.
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $this->applyScope($builder, $model);
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder Builder instance.
     * @param \App\Contracts\HasStatus              $model   Model instance.
     *
     * @return void
     */
    private function applyScope(Builder $builder, HasStatus $model): void
    {
        $builder->where('status', $model->getApprovedStatus());
    }
}
