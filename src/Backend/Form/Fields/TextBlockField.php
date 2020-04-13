<?php

namespace Bambamboole\LaravelCms\Backend\Form\Fields;

use Illuminate\Http\Request;

class TextBlockField extends Field
{
    public string $component = 'TextBlockField';

    public function shouldBeRemoved(Request $request): bool
    {
        return true;
    }
}
