<?php

namespace Bambamboole\LaravelCms\Models;


use Illuminate\Support\Facades\Auth;

/**
 * @property string avatar
 */
class Page extends BaseModel
{
    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'body' => '',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['author'];

    /**
     * Get the authors avatar or the current authenticated users if the author object is null (i.e. create)
     *
     * @return string
     */
    public function getAuthorAttribute()
    {
        return is_null($this->author_id) ? Auth::user() : User::find($this->author_id);
    }
}
