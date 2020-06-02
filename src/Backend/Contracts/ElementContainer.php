<?php

namespace Oscer\Cms\Backend\Contracts;

use Illuminate\Database\Eloquent\Model;

interface ElementContainer
{
    public function getElements(): array;

    public function resolveElements(Model $model): self;
}
