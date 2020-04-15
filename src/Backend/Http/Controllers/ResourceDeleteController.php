<?php

namespace Bambamboole\LaravelCms\Backend\Http\Controllers;

use Bambamboole\LaravelCms\Core\Http\Requests\ResourceRequest;

class ResourceDeleteController
{
    public function handle(ResourceRequest $request)
    {
        $resourceModel = $request
            ->newResourceModel()
            ->show($request->identifier());

        $resourceModel->delete();

        return response()->json(['success' => true]);
    }
}
