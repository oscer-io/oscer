<?php

namespace Bambamboole\LaravelCms\Core\Menus\Forms;

use Bambamboole\LaravelCms\Backend\Form\Fields\SelectField;
use Bambamboole\LaravelCms\Backend\Form\Fields\SelectListField;
use Bambamboole\LaravelCms\Backend\Form\Fields\TextField;
use Bambamboole\LaravelCms\Backend\Form\Form;
use Bambamboole\LaravelCms\Core\Menus\Models\MenuItem;
use Bambamboole\LaravelCms\Core\Posts\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MenuItemForm extends Form
{
    public function fields(): Collection
    {
        return collect([
            // Name field
            TextField::make('name')->rules(['required', 'string']),

            // Type field (url|post-selection)
            SelectField::make(
                'type',
                'Type',
                function () {
                    return [];
                },
                function () {
                    return null;
                }
            )
                ->rules(['required'])
                ->options( // we pass the names of the fields here
                    [
                        [
                            'name' => 'url',
                            'label' => 'Custom Url',
                            'value' => 'url',
                        ],
                        [
                            'name' => 'post',
                            'label' => 'Posts',
                            'value' => 'post',
                        ]
                    ]
                ),

            TextField::make('url')
                ->rules(['required', 'string'])
                ->disable()
                ->dependsOn('type', 'url'),

            // Post selection field
            SelectListField::make(
                'post',
                'Posts',
                null,
                function (MenuItem $resource, Request $request) {
//                    $id = $request->input('post');
//                    $post = Post::query()->where('slug', $id)->first();
//                    $resource->url = implode('/', [$post->type, $post->slug]);
                }
            )
                ->rules(['required', 'string'])
                ->options(
                    Post::all()
                        ->map(
                            function ($post) {
                                return [
                                    'name' => $post->name,
                                    'label' => $post->name,
                                    'value' => $post->slug,
                                ];
                            }
                        )
                        ->toArray()
                )
                ->disable()
                ->dependsOn('type', 'post')
        ]);
    }

    public function beforeSave(Request $request)
    {
        $this->resource->menu = $request->input('menu');
        $this->resource->order = $request->input('order');
    }
}
