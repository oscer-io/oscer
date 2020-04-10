<?php

namespace Bambamboole\LaravelCms\Tests\Fixtures;

use Bambamboole\LaravelCms\Backend\Contracts\FormResource;
use Bambamboole\LaravelCms\Backend\Form\Form;

class TestCreateResource implements FormResource
{

    /**
     * @inheritDoc
     */
    public function isCreation(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function findByIdentifier(string $identifier): FormResource
    {
        // TODO: Implement findByIdentifier() method.
    }

    /**
     * @inheritDoc
     */
    public function save()
    {
        // TODO: Implement save() method.
    }

    /**
     * @inheritDoc
     */
    public function asApiResource()
    {
        // TODO: Implement asApiResource() method.
    }

    /**
     * @inheritDoc
     */
    public function getForm(): Form
    {
        // TODO: Implement getForm() method.
    }
}
