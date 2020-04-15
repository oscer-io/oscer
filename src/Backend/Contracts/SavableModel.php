<?php

namespace Bambamboole\LaravelCms\Backend\Contracts;

/**
 * This  interface is an extension of the "DisplayableModel". A model
 * needs to implement it if it should be updated by a resource.
 */
interface SavableModel extends DisplayableModel
{
    /**
     * This method is called after each fields fillCallback was called.
     * @return mixed
     */
    public function save();

    /**
     * Determines if the model is new.
     * @return bool
     */
    public function isNew(): bool;

    /**
     * Deletes itself
     */
    public function delete();
}
