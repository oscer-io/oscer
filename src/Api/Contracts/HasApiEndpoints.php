<?php

namespace Bambamboole\LaravelCms\Api\Contracts;

use Illuminate\Database\Eloquent\Model;

interface HasApiEndpoints
{
    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newQuery();

    public function getEndpoints(): array;

    public function asResourceCollection($models);

    public function asResource(Model $model);
}
