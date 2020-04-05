<?php

namespace Bambamboole\LaravelCms\Api\Contracts;

interface HasDeleteEndpoint
{
    public function executeDelete($identifier);
}
