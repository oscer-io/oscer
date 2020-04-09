<?php

namespace Bambamboole\LaravelCms\Backend\Contracts;

use Bambamboole\LaravelCms\Backend\Form\Form;
use Illuminate\Contracts\Support\Responsable;

/**
 * This interface needs to implemented to use a resourse as a FormResource
 */
interface FormResource
{
    /**
     * This method determines is this will be a create or a update form
     */
    public function isCreation(): bool;

    /**
     * This method returns the FormResource for an update form
     */
    public function findByIdentifier(string $identifier): FormResource;

    /**
     * This method saves the resource after the field values
     * are assigned to public properties
     */
    public function save(): FormResource;

    /**
     * This method returns the resource after the save.
     * @return Responsable|array
     */
    public function asApiResource();

    /**
     * This method returns the actual Form which will be used for the resource
     */
    public function getForm(): Form;
}
