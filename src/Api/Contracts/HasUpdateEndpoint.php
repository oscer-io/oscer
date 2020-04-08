<?php

namespace Bambamboole\LaravelCms\Api\Contracts;

use Illuminate\Http\Request;

interface HasUpdateEndpoint
{
    public function executeUpdate(Request $request, $identifier);
}
