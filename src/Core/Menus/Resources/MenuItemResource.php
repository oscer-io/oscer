<?php

namespace Bambamboole\LaravelCms\Core\Menus\Resources;

use Bambamboole\LaravelCms\Backend\Resources\Fields\SelectField;
use Bambamboole\LaravelCms\Backend\Resources\Fields\TextField;
use Bambamboole\LaravelCms\Backend\Resources\Resource;
use Bambamboole\LaravelCms\Core\Menus\Models\MenuItem;
use Bambamboole\LaravelCms\Core\Posts\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MenuItemResource extends Resource
{
    public static string $model = MenuItem::class;

    public function fields(): Collection
    {
        $null = function () {
        };

        return collect([
            // Name field
            TextField::make('name')->rules(['required', 'string']),

            // Type field (url|post-selection)
            SelectField::make(
                'type',
                'Type',
                $null,
                $null
            )
                ->rules(['required'])
                ->options( // we pass the names of the fields here
                    [
                        [
                            'name' => 'url',
                            'label' => 'Custom Url',
                        ],
                        [
                            'name' => 'post',
                            'label' => 'Posts',
                        ],
                    ]
                ),

            // custom url field
            TextField::make('url')
                ->rules(['required', 'string'])
                ->disable()
                ->dependsOn('type'),

            //
            SelectField::make(
                'post',
                'Posts',
                $null,
                function (MenuItem $resource, Request $request) {
                    $id = $request->input('post');
                    $post = Post::query()->where('slug', $id)->first();
                    //todo: maybe better associate the id instead of creating the url string
                    $resource->url = '/'.$post->type.'/'.$post->slug;
                }
            )
                ->rules(['required', 'string'])
                ->options(
                    Post::all()
                        ->map(
                            function ($post) {
                                return [
                                    'name' => $post->name,
                                    'value' => $post->slug,
                                ];
                            }
                        )
                        ->toArray()
                )
                ->disable()
                ->dependsOn('type')
                ->searchable()
                ->placeholder(__('cms::menus.search_post')),
        ]);
    }

    public function beforeSave(Request $request)
    {
        if ($request->route('id') === null) {
            $this->resourceModel->menu_id = $request->input('menu');
            $this->resourceModel->order = $request->input('order');
        }
    }
}
