<?php

namespace Oscer\Cms\Core\Users\Models;

use Oscer\Cms\Core\Mails\NewUserCreatedMail;
use Oscer\Cms\Core\Models\BaseModel;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\Authorizable as AuthorizableTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
class User extends BaseModel implements Authenticatable, Authorizable
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

    protected $attributes = [
        'language' => 'en',
    ];

    protected $appends = ['assigned_permissions'];

    /**
     * The column name of the "remember me" token.
     *
     * @var string
     */
    protected $rememberTokenName = 'remember_token';

    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $user) {
            if (! $user->password) {
                $password = Str::random();
                $user->password = $password;

                Mail::to($user->email)->send(new NewUserCreatedMail($password));
            }
        });
    }

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
        return $value
            ? Storage::url($value)
            : 'https://secure.gravatar.com/avatar/'.md5(strtolower(trim($this->email))).'?s=80';
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Get all permission names that are assigned to the current user.
     */
    public function getAssignedPermissionsAttribute()
    {
        return $this->getAllPermissions()
            ->reduce(function ($result, $permission) {
                $result[] = $permission->name;

                return $result;
            }, []);
    }
}
