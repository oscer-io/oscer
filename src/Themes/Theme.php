<?php

namespace Bambamboole\LaravelCms\Themes;

interface Theme
{
    public function getPageTemplate(): string;

    public function getBlogIndexTemplate(): string;

    public function getBlogPostTemplate(): string;
}
