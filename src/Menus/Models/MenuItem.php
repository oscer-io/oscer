<?php

namespace Bambamboole\LaravelCms\Menus\Models;

use Bambamboole\LaravelCms\Api\Contracts\HasApiEndpoints;
use Bambamboole\LaravelCms\Api\Contracts\HasDeleteEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasIndexEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasShowEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasStoreEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasUpdateEndpoint;
use Bambamboole\LaravelCms\Backend\Contracts\HasForm;
use Bambamboole\LaravelCms\Core\Models\BaseModel;
use Bambamboole\LaravelCms\Frontend\Contracts\Theme;
use Bambamboole\LaravelCms\Menus\Forms\MenuItemForm;
use Bambamboole\LaravelCms\Menus\Http\Resources\MenuItemResource;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

/**
 * @property int id
 * @property string name
 * @property string url
 * @property string menu
 * @property int order
 * @property Carbon updated_at
 * @property Carbon created_at
 */
class MenuItem extends BaseModel implements HasForm, HasApiEndpoints, HasIndexEndpoint, HasShowEndpoint, HasStoreEndpoint, HasUpdateEndpoint, HasDeleteEndpoint
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

    public function executeStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'menu' => [Rule::in(collect(app(Theme::class)->getMenus())->keys())],
            'name' => ['required', 'string'],
            'url' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $model = $this->newQuery()->create(array_merge(
            $validator->valid(),
            ['order' => MenuItem::query()->where('menu', $request->input('menu'))->count() + 1]
        ));

        return new MenuItemResource($model);
    }

    public function executeUpdate(Request $request, $identifier)
    {
        $validator = Validator::make($request->all(), [
            'menu' => [Rule::in(collect(app(Theme::class)->getMenus())->keys())],
            'name' => ['filled', 'string'],
            'url' => ['filled', 'string'],
            'order' => ['filled', 'numeric'],
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $model = $this->newQuery()->findOrFail($identifier);
        $model->update($validator->valid());

        return new MenuItemResource($model);
    }

    public function executeDelete($id)
    {
        $this->newQuery()->findOrFail($id)->delete();

        return ['success' => true];
    }
}
