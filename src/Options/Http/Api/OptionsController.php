<?php

namespace Bambamboole\LaravelCms\Options\Http\Controllers\Api;

use Bambamboole\LaravelCms\Options\Http\Requests\CreateOrUpdateOptionRequest;
use Bambamboole\LaravelCms\Options\Http\Resources\OptionResource;
use Bambamboole\LaravelCms\Options\OptionRepository;

class OptionsController
{
    protected OptionRepository $repository;

    public function __construct(OptionRepository $resolver)
    {
        $this->repository = $resolver;
    }

    public function index()
    {
        return ['data' => $this->repository->getOptionFields()];
    }

    public function store(CreateOrUpdateOptionRequest $request)
    {
        $option = $this->repository
            ->store($request->input('key'), $request->input('value'));

        return (new OptionResource($option))
            ->response()
            ->setStatusCode(201);
    }
}
