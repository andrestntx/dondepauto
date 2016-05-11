<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 26/04/2016
 * Time: 5:48 PM
 */

namespace App\Entities\Platform\Space;


use App\Entities\Platform\Entity;
use Illuminate\Database\Eloquent\Model;

class Space extends Entity
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_espacio_LI';

    protected $attr = ['name' => 'nombre_espacio_LI'];

    protected $appends = ['category_name'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bd_espacios_ofrecidos_LIST';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function zone()
    {
        return $this->belongsTo(SpaceCityZone::class, 'id_zona_ciudad_LI');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(SpaceCity::class, 'id_ciudad_LI');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subCategory()
    {
        return $this->belongsTo(SpaceSubCategory::class, 'id_subcat_LI');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function format()
    {
        return $this->belongsTo(SpaceFormat::class, 'id_formato_LI', 'id_formato_LI');
    }

    /**
     * @return Model
     */
    public function getCategory()
    {
        return $this->subCategory->category;
    }

    /**
     * @return string
     */
    public function getCategoryNameAttribute()
    {
        return $this->getCategory()->name;
    }

    /**
     * @return Model
     */
    public function getCity()
    {
        if($this->zone){
            return $this->zone->city;
        }

        return $this->city;
    }

    /**
     * @return mixed|string
     */
    public function getCityNameAttribute()
    {
        if($this->getCity()){
            return $this->getCity()->name;
        }
        
        return 'Sin ciudad';
    }
}