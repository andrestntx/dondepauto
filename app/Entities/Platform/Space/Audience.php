<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:14 AM
 */

namespace App\Entities\Platform\Space;

use App\Entities\Platform\Entity;

class Audience extends Entity
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(AudienceType::class);
    }

    /**
     * @return string
     */
    public function getTypeNameAttribute()
    {
        return $this->type->name;
    }

    /**
     * @return string
     */
    public function getNameTypeNameAttribute()
    {
        return $this->type_name . ' - ' . $this->name;
    }

}