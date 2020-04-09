<?php

namespace Bambamboole\LaravelCms\Core\Menus\Models;

use Bambamboole\LaravelCms\Api\Contracts\HasApiEndpoints;
use Bambamboole\LaravelCms\Api\Contracts\HasDeleteEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasIndexEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasShowEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasStoreEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasUpdateEndpoint;
use Bambamboole\LaravelCms\Backend\Contracts\FormResource;
use Bambamboole\LaravelCms\Backend\Form\Form;
use Bambamboole\LaravelCms\Core\Menus\Forms\MenuItemForm;
use Bambamboole\LaravelCms\Core\Menus\Resources\MenuItemResource;
use Bambamboole\LaravelCms\Core\Models\BaseModel;
use Bambamboole\LaravelCms\Frontend\Contracts\Theme;
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
class MenuItem extends BaseModel implements
    FormResource,
    HasApiEndpoints,
    HasIndexEndpoint,
    HasShowEndpoint,
    HasStoreEndpoint,
    HasUpdateEndpoint,
    HasDeleteEndpoint
{
    public function getForm(): Form
    {
        return new MenuItemForm($this);
    }

    public function executeIndex()
    {
        return MenuItemResource::collection($this->newQuery()->paginate());
    }

    public function executeShow($identifier)
    {
        return $this->findByIdentifier($identifier)->asApiResource();
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
            ['order' => self::query()->where('menu', $request->input('menu'))->count() + 1]
        ));

        return $model->asApiResource();
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

        $model = $this->findByIdentifier($identifier);
        $model->update($validator->valid());

        return $model->asApiResource();
    }

    public function executeDelete($id)
    {
        $this->newQuery()->findOrFail($id)->delete();

        return ['success' => true];
    }

    public function isCreation(): bool
    {
        return $this->id === null;
    }

    public function findByIdentifier(string $identifier): FormResource
    {
        return $this->newQuery()->findOrFail($identifier);
    }

    public function asApiResource()
    {
        return new MenuItemResource($this);
    }
}
