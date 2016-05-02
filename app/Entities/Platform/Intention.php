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
    protected $table = 'bd_intenciones_compra_espacios_ofrecidos_LIST';

    protected $attr = ['id' => 'id_intencion_LI', 'state' => 'estado_intencion_LI'];

}