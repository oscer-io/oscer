<?php

namespace Bambamboole\LaravelCms\Api\Contracts;

interface HasApiEndpoints
{
    public function getEndpoints(): array;
}
