<?php

namespace Oscer\Cms\Backend;

class ScriptHandler
{
    protected array $scripts = [];

    public function addScript(string $path)
    {
        $this->scripts[] = $path;
    }

    public function getScripts()
    {
        return $this->scripts;
    }
}
