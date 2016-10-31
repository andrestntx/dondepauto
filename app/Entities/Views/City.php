<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 1:31 PM
 */

namespace App\Entities\Views;

use App\Entities\Proposal\Proposal;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'view_cities';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proposal()
    {
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }
}