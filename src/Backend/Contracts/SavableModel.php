<?php

namespace Bambamboole\LaravelCms\Backend\Contracts;

interface SavableModel extends DisplayableModel
{
    public function save();

    public function isNew(): bool;
}
