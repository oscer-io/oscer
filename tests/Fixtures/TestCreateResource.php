<?php

namespace Bambamboole\LaravelCms\Tests\Fixtures;

use Bambamboole\LaravelCms\Backend\Contracts\FormResource;
use Bambamboole\LaravelCms\Backend\Form\Form;

class TestCreateResource implements FormResource
{
    public function isCreation(): bool
    {
        return true;
    }

    public function findByIdentifier(string $identifier): FormResource
    {
        //
    }

    public function save()
    {
        //
    }

    public function asApiResource()
    {
        //
    }

    public function getForm(): Form
    {
        //
    }
}
