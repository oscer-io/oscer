<?php

namespace Bambamboole\LaravelCms\Backend\Http\Controllers;

use Bambamboole\LaravelCms\Backend\Http\Requests\ResourceRequest;

class ResourceDeleteController
{
    public function handle(ResourceRequest $request)
    {
        $resourceModel = $request
            ->newResourceModel()
            ->newQuery()
            ->findOrFail($request->identifier());

        $resourceModel->delete();

        return response()->json(['success' => true]);
    }
}
