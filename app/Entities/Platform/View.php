<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:14 AM
 */

namespace App\Entities\Platform;


use Carbon\Carbon;

class View extends Entity
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_LI';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'visualizacion_espacios_ofrecidos_LIST';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['view_at'];

    protected $databaseTranslate = ['view_at' => 'fechaVisualizacion_LI'];
}