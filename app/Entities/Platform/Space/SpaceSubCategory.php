<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:14 AM
 */

namespace App\Entities\Platform\Space;

use App\Entities\Platform\Entity;

class SpaceSubCategory extends Entity
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_subcat_LI';

    protected $databaseTranslate = ['name' => 'nombre_subcat_LI', 'description' => 'description_subcat_LI', 'category_id' => 'id_cat_LI'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'subcat_espacios_ofrecidos_LIST';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(SpaceCategory::class, 'id_cat_LI', 'id_cat_LI');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function formats()
    {
        return $this->hasMany(SpaceFormat::class, 'id_subcat_LI', 'id_subcat_LI');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function spaces()
    {
        return $this->hasMany(Space::class, 'id_subcat_LI', 'id_subcat_LI');
    }

    /**
     * @return string
     */
    public function getCategoryNameAttribute()
    {
        return $this->category->name;
    }

    /**
     * @return string
     */
    public function getNameCategoryNameAttribute()
    {
        return $this->category_name . ' - ' . $this->name;
    }

}