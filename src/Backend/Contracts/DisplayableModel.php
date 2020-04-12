<?php

namespace Bambamboole\LaravelCms\Backend\Contracts;

/**
 * Classes which have a Resource needs to implements this interface
 */
interface DisplayableModel
{
    /**
     * This method returns the models for an index response
     * @return mixed
     */
    public function index();

    /**
     * This method returns one model for a show response
     * @return mixed
     */
    public function show(string $identifier);
}
