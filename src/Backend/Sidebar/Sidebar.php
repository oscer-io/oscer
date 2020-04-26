<?php

namespace Oscer\Cms\Backend\Sidebar;

use Illuminate\Http\Request;
use Oscer\Cms\Core\Users\Models\Role;

class Sidebar implements \JsonSerializable
{
    protected array $items = [];

    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function addItem(SidebarItem $item)
    {
        $this->items[] = $item;

        return $this;
    }

    public function authorizeItems()
    {
        return array_filter($this->items,function (SidebarItem $item){
            return
                $this->request->user()->can($item->getPermission());
        });
    }

    public function jsonSerialize()
    {
        return [
            'items' => $this->authorizeItems(),
        ];
    }
}
