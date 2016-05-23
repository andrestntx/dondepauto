<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:14 AM
 */

namespace App\Entities\Platform;


class Neighborhood extends Entity
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_barrio_LI';

    protected $databaseTranslate = ['name' => 'nombre_barrio_LI'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'barrios_LIST';


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function locality()
    {
        return $this->belongsTo(Locality::class, 'id_formato_LI', 'id_formato_LI');
    }

}