<?php

namespace Bambamboole\LaravelCms\Core\Users\Models;

use Bambamboole\LaravelCms\Api\Contracts\HasApiEndpoints;
use Bambamboole\LaravelCms\Api\Contracts\HasDeleteEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasIndexEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasShowEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasStoreEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasUpdateEndpoint;
use Bambamboole\LaravelCms\Backend\Contracts\HasForm;
use Bambamboole\LaravelCms\Core\Models\BaseModel;
use Bambamboole\LaravelCms\Core\Users\Forms\UserForm;
use Bambamboole\LaravelCms\Core\Users\Resources\UserResource;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\Authorizable as AuthorizableTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int id
 * @property string name
 * @property string email
 * @property string bio
 * @property string avatar
 * @property Carbon updated_at
 * @property Carbon created_at
 */
class User extends BaseModel implements
    Authenticatable,
    Authorizable,
    HasForm,
    HasApiEndpoints,
    HasIndexEndpoint,
    HasShowEndpoint,
    HasStoreEndpoint,
    HasUpdateEndpoint,
    HasDeleteEndpoint
{
    use HasApiTokens;
    use HasRoles;
    use AuthorizableTrait;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The column name of the "remember me" token.
     *
     * @var string
     */
    protected $rememberTokenName = 'remember_token';

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return $this->getKeyName();
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->{$this->getAuthIdentifierName()};
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string|null
     */
    public function getRememberToken()
    {
        if (! empty($this->getRememberTokenName())) {
            return (string) $this->{$this->getRememberTokenName()};
        }
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param string $value
     * @return void
     */
    public function setRememberToken($value)
    {
        if (! empty($this->getRememberTokenName())) {
            $this->{$this->getRememberTokenName()} = $value;
        }
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return $this->rememberTokenName;
    }

    /**
     * Get the author's avatar.
     *
     * @param string $value
     * @return string
     */
    public function getAvatarAttribute($value)
    {
        return $value ? Storage::url($value) : 'https://secure.gravatar.com/avatar/'.md5(strtolower(trim($this->email))).'?s=80';
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function getForm()
    {
        return new UserForm($this);
    }

    public function executeIndex()
    {
        return UserResource::collection($this->newQuery()->paginate());
    }

    public function executeShow($id)
    {
        return new UserResource($this->newQuery()->findOrFail($id));
    }

    public function executeStore(Request $request)
    {
        $form = $this->getForm();
        $form->setData($request->all());
        $validator = $form->getValidator();

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $model = $form->save();

        return new UserResource($model);
    }

    public function executeUpdate(Request $request, $identifier)
    {
        $model = $this->newQuery()->findOrFail($identifier);
        $form = $model->getForm();
        $form->setData($request->all());
        $validator = $form->getValidator();

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $updatedModel = $form->save();

        return new UserResource($updatedModel);
    }

    public function executeDelete($id)
    {
        $this->newQuery()->findOrFail($id)->delete();

        return ['success' => true];
    }
}
