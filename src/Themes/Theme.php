<?php

namespace Bambamboole\LaravelCms\Themes;

interface Theme
{
    public function getPageTemplate(): string;

    public function getPostIndexTemplate(): string;

    public function getPostShowTemplate(): string;
}
