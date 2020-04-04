<?php

namespace Bambamboole\LaravelCms\Core\Models;

use Bambamboole\LaravelCms\Api\Contracts\HasApiEndpoints;
use Bambamboole\LaravelCms\Api\Contracts\HasDeleteEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasIndexEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasShowEndpoint;
use Bambamboole\LaravelCms\Backend\Contracts\HasForm;
use Bambamboole\LaravelCms\Core\Forms\UserForm;
use Bambamboole\LaravelCms\Users\Http\Resources\UserResource;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int id
 * @property string name
 * @property string email
 * @property string bio
 * @property string avatar
 * @property Carbon updated_at
 * @property Carbon created_at
 */
class User extends BaseModel implements Authenticatable, HasForm, HasApiEndpoints, HasIndexEndpoint, HasShowEndpoint, HasDeleteEndpoint
{
    use HasApiTokens;

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
        return $value ?: 'https://secure.gravatar.com/avatar/'.md5(strtolower(trim($this->email))).'?s=80';
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function getForm()
    {
        return new UserForm($this);
    }

    public function getEndpoints(): array
    {
        return ['index', 'show', 'delete'];
    }

    public function executeIndex()
    {
        return UserResource::collection($this->newQuery()->paginate());
    }

    public function executeShow($id)
    {
        return new UserResource($this->newQuery()->findOrFail($id));
    }

    public function executeDelete($id)
    {
        $this->newQuery()->findOrFail($id)->delete();

        return ['success' => true];
    }
}