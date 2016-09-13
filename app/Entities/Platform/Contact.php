<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:14 AM
 */

namespace App\Entities\Platform;


use App\Entities\Views\Publisher;

class Contact extends Entity
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
    protected $table = 'contacts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comments'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['action', 'created_at_humans', 'created_at_format'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function actions()
    {
        return $this->belongsToMany(Action::class, 'action_contact', 'contact_id', 'action_id')
            ->withPivot('action_at')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function publisher()
    {
        return $this->belongsTo(Publisher::class, 'user_id');
    }

    /**
     * @return mixed
     */
    public function getActionAttribute()
    {
        return $this->actions->first();
    }

    /**
     * @return mixed
     */
    public function getCreatedAtHumansAttribute()
    {
        return ucfirst($this->created_at->diffForHumans());
    }

    /**
     * @return string
     */
    public function getCreatedAtFormatAttribute()
    {
        return $this->created_at->format('d-M-y') . ' (' . $this->created_at_humans .')';
    }
}