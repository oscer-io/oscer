<?php

namespace Oscer\Cms\Backend\Http\Controllers;

use Oscer\Cms\Backend\Http\Requests\ResourceRequest;

class ResourceCreateController
{
    public function handle(ResourceRequest $request)
    {
        $resourceModel = $request->newResourceModel();
        $resourceClass = $request->getResource();

        return response()->json(['data' => (new $resourceClass($resourceModel))->prepareForForm()]);
    }
}
