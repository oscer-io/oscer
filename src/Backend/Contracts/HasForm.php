<?php

namespace Bambamboole\LaravelCms\Backend\Contracts;

interface HasForm
{
    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newQuery();

    public function getForm();
}
