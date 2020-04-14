<?php

namespace Bambamboole\LaravelCms\Tests\Fixtures;

use Bambamboole\LaravelCms\Backend\Contracts\SavableModel;

class TestModel implements SavableModel
{
    public int $id = 1;

    public string $test = 'value initially set for test';

    public function index()
    {
        // TODO: Implement index() method.
    }

    public function show(string $identifier)
    {
        // TODO: Implement show() method.
    }

    public function save()
    {
        // TODO: Implement save() method.
    }

    public function isNew(): bool
    {
        return false;
    }
}
