<?php

namespace Oscer\Cms\Backend\Sidebar;

class SidebarItem implements \JsonSerializable
{
    protected string $icon;

    protected string $label;

    protected string $target;

    protected string $permission;

    public function __construct(string $icon, string $label, string $target, string $permission = '')
    {
        $this->icon = $icon;
        $this->label = $label;
        $this->target = $target;
        $this->permission = $permission === '' ? 'backend.view' : $permission;
    }

    public function getPermission()
    {
        return $this->permission;
    }

    public function resolveIcon()
    {
        return svg(
            "cms:{$this->icon}",
            'mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150')
            ->toHtml();
    }

    public function jsonSerialize()
    {
        return [
            'icon' => $this->resolveIcon(),
            'label' => $this->label,
            'target' => $this->target,
            'permission' => $this->permission,
        ];
    }
}
