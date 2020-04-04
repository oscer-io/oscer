<?php

namespace Bambamboole\LaravelCms\Menus\Models;

use Bambamboole\LaravelCms\Api\Contracts\HasApiEndpoints;
use Bambamboole\LaravelCms\Api\Contracts\HasDeleteEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasIndexEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasShowEndpoint;
use Bambamboole\LaravelCms\Backend\Contracts\HasForm;
use Bambamboole\LaravelCms\Core\Models\BaseModel;
use Bambamboole\LaravelCms\Menus\Forms\MenuItemForm;
use Bambamboole\LaravelCms\Menus\Http\Resources\MenuItemResource;
use Illuminate\Support\Carbon;

/**
 * @property int id
 * @property string name
 * @property string url
 * @property string menu
 * @property int order
 * @property Carbon updated_at
 * @property Carbon created_at
 */
class MenuItem extends BaseModel implements HasForm, HasApiEndpoints, HasIndexEndpoint, HasShowEndpoint, HasDeleteEndpoint
{
    public function getForm()
    {
        return new MenuItemForm($this);
    }

    public function getEndpoints(): array
    {
        return ['index', 'show', 'delete'];
    }

    public function executeIndex()
    {
        return MenuItemResource::collection($this->newQuery()->paginate());
    }

    public function executeShow($identifier)
    {
        return new MenuItemResource($this->newQuery()->findOrFail($identifier));
    }

    public function executeDelete($id)
    {
        $this->newQuery()->findOrFail($id)->delete();

        return ['success' => true];
    }
}
