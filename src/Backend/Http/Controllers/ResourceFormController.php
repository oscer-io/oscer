<?php

namespace Bambamboole\LaravelCms\Backend\Http\Controllers;

use Bambamboole\LaravelCms\Backend\Form\Form;
use Illuminate\Http\Request;

class ResourceFormController
{
    public function new($resource)
    {
        return Form::create($resource);
    }

    public function show($resource, $id = null)
    {
        if (strpos($id, ',')) {
            return Form::createMultiple($resource, explode(',', $id));
        }

        return Form::create($resource, $id);
    }

    public function store(Request $request, $resource)
    {
        $form = Form::create($resource);
        $form->setData($request->all());
        $validator = $form->getValidator();

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $resource = $form->save();

        return response()->json($resource)->setStatusCode($resource->wasRecentlyCreated ? 201 : 200);
    }

    public function update(Request $request, $resource, $id)
    {
        $form = Form::create($resource, $id);
        $form->setData($request->all());
        $validator = $form->getValidator();

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $resource = $form->save();

        return response()->json($resource)->setStatusCode($resource->wasRecentlyCreated ? 201 : 200);
    }
}
