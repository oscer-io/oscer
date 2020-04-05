<?php

namespace Bambamboole\LaravelCms\Api\Contracts;

interface HasShowEndpoint
{
    public function executeShow($identifier);
}
