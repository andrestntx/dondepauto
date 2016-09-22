<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 12/07/2016
 * Time: 8:32 AM
 */

namespace App\Entities\Platform;


class Representative extends Entity
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'legal_representatives';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'doc'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class, 'legal_representative_id', 'id');
    }


    /**
     * @return string
     */
    public function getFirstNameAttribute()
    {
        if(! empty($this->name)) {
            return explode(' ', $this->name)[0];
        }

        return '';
    }
}