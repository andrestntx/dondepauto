<?php

namespace App\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Encrypt the users password
     * @param string $value
     */
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = \Hash::make($value);
        }
    }

    /**
     * Return the Full Name 
     * @return string
     */
    public function getNameAttribute()
    {
        return ucwords($this->first_name . ' ' . $this->last_name);
    }

    /**
     * @param $query
     * @param $role
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRole($query, $role)
    {
        return $query->whereRole($role);
    }

    /**
     * @param $query
     * @param array $roles
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRoles($query, array $roles)
    {
        return $query->whereIn('role', $roles);
    }

    /**
     * @param string $role
     * @return bool
     */
    public function isRole($role)
    {
        return $this->role == $role;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->isRole('admin');
    }

    /**
     * @return bool
     */
    public function isDirector()
    {
        return $this->isRole('director');
    }

    /**
     * @return bool
     */
    public function isAdviser()
    {
        return $this->isRole('adviser');
    }

    /**
     * Get the clients for the adviser.
     */
    public function clients()
    {
        return $this->hasMany('App\Entities\Platform\User');
    }
}
