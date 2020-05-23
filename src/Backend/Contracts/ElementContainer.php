<?php

namespace Oscer\Cms\Backend\Contracts;

use Illuminate\Support\Collection;

interface ElementContainer
{
    public function getElements(): Collection;
}
