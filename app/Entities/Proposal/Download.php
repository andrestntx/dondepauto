<?php
/**
 * Created by PhpStorm.
 * User: andrestntx
 * Date: 9/20/16
 * Time: 11:05 AM
 */

namespace App\Entities\Proposal;


use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['url'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function proposal()
    {
        return $this->hasOne(Proposal::class);
    }
}