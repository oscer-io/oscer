<?php

namespace Bambamboole\LaravelCms\Backend\Contracts;

interface DisplayableModel
{
    public function index();

    public function show(string $identifier);
}
