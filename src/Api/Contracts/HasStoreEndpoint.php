<?php

namespace Bambamboole\LaravelCms\Api\Contracts;

use Illuminate\Http\Request;

interface HasStoreEndpoint
{
    public function executeStore(Request $request);
}
