<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:21 AM
 */

namespace App\Repositories\Platform\Space;


use App\Repositories\BaseRepository;

class SpaceFormatRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\Platform\Space\SpaceFormat';
    }

    /**
     * @param null $subCategory_id
     * @param string $column
     * @param string $id
     * @return mixed
     */
    public function formatsWithSpaces($subCategory_id = null, $column = "nombre_formato_LI", $id = "bd_formatos_espacios_ofrecidos_LIST.id_formato_LI")
    {
        $query = $this->model
            ->join('bd_espacios_ofrecidos_LIST', 'bd_espacios_ofrecidos_LIST.id_formato_LI', '=', 'bd_formatos_espacios_ofrecidos_LIST.id_formato_LI')
            ->groupBy('bd_formatos_espacios_ofrecidos_LIST.id_formato_LI')
            ->orderBy('nombre_formato_LI', 'asc');

        if(! is_null($subCategory_id) && ! empty($subCategory_id) ){
            $query->where('bd_formatos_espacios_ofrecidos_LIST.id_subcat_LI', $subCategory_id);
        }

        return $query->lists($column, $id)->all();
    }
}