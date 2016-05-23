<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:14 AM
 */

namespace App\Entities\Platform\Space;


use App\Entities\Platform\Entity;
use Illuminate\Database\Eloquent\Model;

class SpaceFormat extends Entity
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_formato_LI';

    protected $databaseTranslate = ['name' => 'nombre_formato_LI', 'description' => 'descripcion_formato_LI', 'sub_category_id' => 'id_subcat_LI'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formatos_espacios_ofrecidos_LIST';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subCategory()
    {
        return $this->belongsTo(SpaceSubCategory::class, 'id_subcat_LI', 'id_subcat_LI');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function spaces()
    {
        return $this->hasMany(Space::class, 'id_formato_LI', 'id_formato_LI');
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
     * @return string
     */
    public function getCategorySubCategoryNameAttribute()
    {
        return $this->subCategory->name . ' - ' . $this->category_name . ' - ' . $this->name;
    }
}