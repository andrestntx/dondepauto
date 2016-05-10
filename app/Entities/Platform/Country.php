<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:14 AM
 */

namespace App\Entities\Platform;


class Country extends Entity
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_pais_LI';

    protected $attr = ['name' => 'nombre_pais_LI', 'code' => 'codigo_pais_LI', 'lang' => 'idioma_pais_LI'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bd_paises_LIST';
}