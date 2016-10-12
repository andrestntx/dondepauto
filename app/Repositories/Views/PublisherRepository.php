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
     * @return mixed
     */
    protected function defaultSearch()
    {
        return $this->model->select([
            'company', 'first_name', 'last_name', 'name', 'email', 'phone', 'cel', 'created_at', 'signed_at', 'comments',
            'signed_agreement', 'activated_at', 'id', 'address', 'email_validated', 'complete_data', 'company_legal',
            'commission_rate', 'discount', 'retention', 'city_name', 'city_id', 'company_nit', 'company_role', 'company_area',
            'economic_activity_name', 'source', 'legal_representative_id', 'change_documents', 'representative_doc', 'representative_email',
            'representative_name', 'representative_phone', 'tag_id'
        ])->with(['spaces' => function($query) {
                $query->select('id_us_reg_LI', 'id_espacio_LI', 'id_subcat_LI', 'fecha_creacion_LI as created_at');
            }, 'contacts' => function($query) {
                $query->orderBy("created_at", "desc");
            },'contacts.actions', 'logs', 'representative', 'spaces.cities'
        ]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getPublisher($id)
    {
        return $this->defaultSearch()->whereId($id)->get()->first();
    }

    /**
     * @param $id
     * @return array
     */
    public function getStates($id)
    {
        $model = $this->model->find($id);

        if($model) {
            return $model->states;
        }

        return [];
    }

    /**
     * @param array $data
     * @param $search
     * @return mixed
     */
    public function search(array $data, $search = '')
    {
        $publisherQuery = $this->defaultSearch();

        if(! empty($search)) {
            $publisherQuery->where(function ($query) use($search) {
                $query->where('company', 'LIKE', '%' . $search . '%')
                    ->orWhere('company_legal', 'LIKE', '%' . $search . '%')
                    ->orWhere('company_nit', 'LIKE', '%' . $search . '%')
                    ->orWhere('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('comments', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%')
                    ->orWhere('representative_doc', 'LIKE', '%' . $search . '%')
                    ->orWhere('representative_email', 'LIKE', '%' . $search . '%')
                    ->orWhere('representative_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('representative_doc', 'LIKE', '%' . $search . '%');
            });
        }

        $this->searchDateRange($data['created_at_datatable'], 'created_at', $publisherQuery);
        $this->searchDateRange($data['signed_at_datatable'], 'signed_at', $publisherQuery);

        if (! empty($data['signed_agreement'])) {
            $publisherQuery->where('signed_agreement', '=', $data['signed_agreement']);
        }

        return $publisherQuery->get();
    }

    protected function searchDateRange($search, $name, &$publisherQuery)
    {
        $dateRange = explode(',', $search);
        if(!empty ($dateRange[0])) {
            $publisherQuery->where($name, '>=', Carbon::createFromFormat('d/m/Y', $dateRange[0])->toDateString());
        }
        if(count($dateRange) >= 2 && !empty ($dateRange[1])) {
            $publisherQuery->where($name, '<=', Carbon::createFromFormat('d/m/Y H:i:s', $dateRange[1] . ' 23:59:59')->toDateTimeString());
        }
    }


    /**
     * @param null $category_id
     * @param null $subCategory_id
     * @param null $format_id
     * @param null $city_id
     * @param null $scene_id
     * @param string $column
     * @param string $id
     * @param null $select
     * @return mixed
     */
    public function publishersWithSpaces($category_id = null, $subCategory_id = null, $format_id = null, $city_id = null, $scene_id = null,
                                         $column = "company", $id = "view_publishers.id", $select = null)
    {
        if(is_null($select)) {
            $select = [$column, $id];
        }

        $query = $this->model
            ->select($select)
            ->joinSpaces()
            ->groupBy('id')
            ->orderBy('company', 'asc');

        if(! is_null($city_id) && !empty($city_id) ){
            $query->joinCities($city_id);
        }

        if(! is_null($scene_id) && !empty($scene_id) ){
            $query->joinScenes($scene_id);
        }

        if(! is_null($format_id) && ! empty($format_id)) {
            $query->where("id_formato_LI", $format_id);
        }
        else if(! is_null($subCategory_id) && ! empty($subCategory_id)) {
            $query->where("id_subcat_LI", $subCategory_id);
        }
        else if(! is_null($category_id) && ! empty($category_id)) {
            $query->where("id_cat_LI", $category_id);
        }
        
        return $query->lists($column, $id)->all();
    }
}