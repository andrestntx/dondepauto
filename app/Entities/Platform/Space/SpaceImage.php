<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:14 AM
 */

namespace App\Entities\Platform\Space;

use App\Entities\Platform\Entity;

class SpaceImage extends Entity
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_imagen_LI';

    protected $databaseTranslate = ['thumb' => 'url_thumb_LI', 'url' => 'url_imagen_LI', 'space_id' => 'id_espacio_LI',
        'thumb_name' => 'url_thumb_LI'];

    protected $appends = ['thumb', 'url'];

    protected $fillable = ['thumb', 'url'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'imagenes_espacios_ofrecidos_LIST';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function space()
    {
        return $this->belongsTo(Space::class, 'id_espacio_LI', 'id_espacio_LI');
    }

    public function getThumbAttribute($value)
    {
        if(\File::exists('images/marketplace/thumbs/' . $this->url_thumb_LI)) {
            return url('/images/marketplace/thumbs/' . $this->url_thumb_LI);
        }

        return 'http://dondepauto.co/images/marketplace/thumbs/' . $this->url_thumb_LI;
    }

    public function getUrlAttribute($value)
    {
        return 'http://dondepauto.co/images/marketplace/big/' . $this->url_imagen_LI;
    }

}