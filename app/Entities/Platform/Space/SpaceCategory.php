<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:14 AM
 */

namespace App\Entities\Platform\Space;

use App\Entities\Platform\Entity;

class SpaceCategory extends Entity
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_cat_LI';

    protected $attr = ['name' => 'nombre_cat_LI', 'id' => 'id_cat_LI'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bd_cat_espacios_ofrecidos_LIST';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subCategories()
    {
        return $this->hasMany(SpaceSubCategory::class, 'id_cat_LI', 'id_cat_LI');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function formats()
    {
        return $this->hasManyThrough(SpaceFormat::class, SpaceSubCategory::class, 'id_subcat_LI', 'id_cat_LI');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function spaces()
    {
        return $this->hasManyThrough(Space::class, SpaceSubCategory::class, 'id_subcat_LI', 'id_cat_LI');
    }


}