<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 26/04/2016
 * Time: 5:48 PM
 */

namespace App\Entities\Platform;


class Space extends Entity
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_espacio_LI';

    protected $attr = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bd_espacios_ofrecidos_LIST';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'id_ciudad_LI');
    }
    
    public function getCityNameAttribute()
    {
        if($this->city){
            return $this->city->name;
        }
        
        return 'Sin ciudad';
    }
}