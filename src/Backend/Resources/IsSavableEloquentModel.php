<?php

namespace Bambamboole\LaravelCms\Backend\Resources;

trait IsSavableEloquentModel
{
    public function index()
    {
        return $this->newQuery()->paginate();
    }

    public function show(string $identifier)
    {
        return $this->newQuery()->findOrFail($identifier);
    }

    public function isNew(): bool
    {
        return $this->id === null;
    }
}
