<?php

namespace Bambamboole\LaravelCms\Backend\Http\Controllers;

use Bambamboole\LaravelCms\Backend\Form\Form;
use Illuminate\Http\Request;

class ResourceFormController
{
    public function show($resource, $id = null)
    {
        if ($id === null) {
            return Form::create($resource);
        }
        if (strpos($id, ',')) {
            return Form::createMultiple($resource, explode(',', $id));
        }

        return Form::create($resource, $id);
    }

    public function store(Request $request, $resource, $id = null)
    {
        $form = Form::create($resource, $id);
        $form->setData($request->all());
        $validator = $form->getValidator();

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $resource = $form->save();

        return response()->json(['data' => $resource])->setStatusCode($resource->wasRecentlyCreated ? 201 : 200);
    }
}
