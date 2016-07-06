<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:14 AM
 */

namespace App\Entities\Platform\Space;

use App\Entities\Platform\Entity;

class AudienceType extends Entity
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function audiences()
    {
        return $this->hasMany(Audience::class);
    }
}