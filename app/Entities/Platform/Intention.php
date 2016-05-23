<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 3:54 PM
 */

namespace App\Entities\Platform;


class Intention extends Entity
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'intenciones_compra_espacios_ofrecidos_LIST';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_intencion_LI';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at'];

    protected $databaseTranslate = ['state' => 'estado_intencion_LI', 'interest_at' => 'url_fecha_intencion_LI',
        'created_at' => 'fecha_envio_intencion_LI'];

    public function getStateAttribute()
    {
        if($this->estado_intencion_LI == 'Pend_envio') {
            return 'interest';
        }

        return $this->commercial_state;
    }

}