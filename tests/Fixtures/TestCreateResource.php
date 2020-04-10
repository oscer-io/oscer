<?php

namespace Bambamboole\LaravelCms\Tests\Fixtures;

use Bambamboole\LaravelCms\Backend\Contracts\FormResource;
use Bambamboole\LaravelCms\Backend\Form\Form;

class TestCreateResource implements FormResource
{
    /**
     * {@inheritdoc}
     */
    public function isCreation(): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function findByIdentifier(string $identifier): FormResource
    {
        // TODO: Implement findByIdentifier() method.
    }

    /**
     * {@inheritdoc}
     */
    public function save()
    {
        // TODO: Implement save() method.
    }

    /**
     * {@inheritdoc}
     */
    public function asApiResource()
    {
        // TODO: Implement asApiResource() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getForm(): Form
    {
        // TODO: Implement getForm() method.
    }
}
