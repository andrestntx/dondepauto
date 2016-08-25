<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 1:22 PM
 */

namespace App\Repositories\Views;


use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PublisherRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\Views\Publisher';
    }


    /**
     * @param array $columns
     * @param array $search
     * @return mixed
     */
    public function search(array $columns, array $search)
    {
        $publisherQuery = $this->model->select([
                'company', 'first_name', 'name', 'email', 'phone', 'cel', 'created_at', 'signed_at', 'comments',
                'signed_agreement', 'activated_at', 'id', 'address', 'email_validated', 'complete_data',
                'commission_rate', 'discount', 'retention', 'city_name', 'company_nit', 'company_role', 'company_area',
                'economic_activity_name'
            ])->with(['spaces' => function($query) {
                    $query->select('id_us_reg_LI', 'id_espacio_LI', 'id_subcat_LI', 'fecha_creacion_LI as created_at', 'id_ciudad_LI as city_id');
                }, 'contacts' => function($query) {
                    $query->orderBy("created_at", "desc");
                },'contacts.actions'/*, 'spaces.city' => function($query) {
                    $query->select('nombre_ciudad_LI as name', 'id_ciudad_LI');
                }*/
            ]);

        if(trim($search['value'])) {
            $value = $search['value'];
            $publisherQuery->where(function ($query) use($value) {
                $query->where('company', 'LIKE', '%' . $value . '%')
                    ->orWhere('name', 'LIKE', '%' . $value . '%')
                    ->orWhere('comments', 'LIKE', '%' . $value . '%')
                    ->orWhere('email', 'LIKE', '%' . $value . '%');
            });
        }

        foreach ($columns as $column) {
            $this->searchDateRange($column, 'created_at_datatable', 'created_at', $publisherQuery);
            $this->searchDateRange($column, 'signed_at_datatable', 'signed_at', $publisherQuery);

            if ($column['name'] == 'signed_agreement' && trim($column['search']['value'])) {
                $publisherQuery->where('signed_agreement', '=', $column['search']['value']);
            }
        }

        return $publisherQuery->get();
    }

    protected function searchDateRange($column, $search, $name, &$publisherQuery)
    {
        if ($column['name'] == $search && trim($column['search']['value'])) {
            $dateRange = explode(',', $column['search']['value']);
            if(trim($dateRange[0])) {
                $publisherQuery->where($name, '>=', Carbon::createFromFormat('d/m/Y', $dateRange[0])->toDateString());
            }
            if(trim($dateRange[1])) {
                $publisherQuery->where($name, '<=', Carbon::createFromFormat('d/m/Y', $dateRange[1])->toDateString());
            }
        }
    }

    /**
     * @param null $category_id
     * @param null $subCategory_id
     * @param null $format_id
     * @param null $city_id
     * @param string $column
     * @param string $id
     * @return mixed
     */
    public function publishersWithSpaces($category_id = null, $subCategory_id = null, $format_id = null, $city_id = null, $column = "company", $id = "id")
    {
        $query = $this->model
            ->join('espacios_ofrecidos_LIST', 'id_us_reg_LI', '=', 'id')
            ->groupBy('id')
            ->orderBy('company', 'asc');

        if(! is_null($format_id) && ! empty($format_id)) {
            $query->where("id_formato_LI", $format_id);
        }
        else if(! is_null($subCategory_id) && ! empty($subCategory_id)) {
            $query->where("id_subcat_LI", $subCategory_id);
        }
        else if(! is_null($category_id) && ! empty($category_id)) {
            $query->where("id_cat_LI", $category_id);
        }

        if(! is_null($city_id) && ! empty($city_id)) {
            $query->where("id_ciudad_LI", $city_id);
        }
        
        return $query->lists($column, $id)->all();
    }
}