<?php

namespace Bambamboole\LaravelCms\Themes;

interface Theme
{
    public function getMenus(): array;

    public function getFrontPageTemplate(): string;

    public function getPageTemplate(): string;

    public function getPostIndexTemplate(): string;

    public function getPostShowTemplate(): string;

    public function getOptions(): array;
}
