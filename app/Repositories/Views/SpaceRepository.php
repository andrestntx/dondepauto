<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 1:22 PM
 */

namespace App\Repositories\Views;


use App\Entities\Platform\User;
use App\Entities\Proposal\Proposal;
use App\Repositories\BaseRepository;

class SpaceRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\Views\Space';
    }

    /**
     * @return mixed
     */
    public function spacesWithProposals()
    {
        return $this->model->join('proposal_space', 'proposal_space.space_id', '=', 'view_spaces.id')
            ->join('proposals', function($join) {
                return $join->on('proposal_space.proposal_id', '=', 'proposals.id')
                    ->whereNull('proposals.deleted_at');
            })
            ->where('proposal_space.title', '<>', '')
            ->groupBy('view_spaces.id')
            ->lists('proposal_space.title', 'view_spaces.id')
            ->all();
    }

    /**
     * @return array
     */
    public function getSelects()
    {
        return [
            "publisher_company", "name", "impacts", "period",
            "category_id", "category_name", "sub_category_id", "sub_category_name", "format_id", "format_name",
            "publisher_commission_rate", "minimal_price", "percentage_markdown", "markup_price", "public_price",
            "percentage_markup",

            "id", "created_at", "active", "tags", "description", "address", "discount", // space

            "publisher_id", "publisher_email", "publisher_phone", "publisher_cel", "publisher_economic_activity_name", // publisher
            "publisher_company_nit", "publisher_company_role", "publisher_company_area", "publisher_first_name", "publisher_last_name"
        ];
    }

    /**
     * @param $spaceId
     */
    public function getSpace($spaceId)
    {
        return $this->model->select($this->getSelects())->with(['images', 'cities', 'impactScenes', 'simplePublisher'])
            ->whereIsDelete(0)
            ->whereId($spaceId)
            ->get()
            ->first();
    }


    public function search(array $data, $search = '', $spaceId = null, User $publisher = null, Proposal $proposal = null)
    {
        if(! is_null($proposal)) {
            $query = $proposal->viewSpaces()
                ->select(["view_spaces.*",
                    "proposal_space.proposal_id as pivot_proposal_id",
                    "proposal_space.space_id as pivot_space_id",
                    "proposal_space.discount as pivot_discount",
                    "proposal_space.with_markup as pivot_with_markup",
                    "proposal_space.title as pivot_title",
                    "proposal_space.description as pivot_description"
                ])
                ->with(['images', 'publisher.spaces', 'audiences.type'])
                ->whereIsDelete(0);
        }
        else {
            $query = $this->model->select($this->getSelects())->with(['images', 'cities', 'impactScenes'])
                ->whereIsDelete(0);
        }

        if(!is_null($publisher)) {
            $query->wherePublisherId($publisher->id);
        }
        if(!is_null($spaceId)){
            $query->where("view_spaces.id", '=', $spaceId);
        }

        $this->query($query, $data, 'active', 'active');
        $this->query($query, $data, 'category_id', 'category_id');
        $this->query($query, $data, 'sub_category_id', 'sub_category_id');
        $this->query($query, $data, 'format_id', 'format_id');
        $this->query($query, $data, 'publisher_id', 'publisher_id');

        if(! empty($search)) {
            $query->where(function ($q) use($search) {
                $q->where('publisher_first_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('publisher_last_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('publisher_company', 'LIKE', '%' . $search . '%')
                    ->orWhere('publisher_email', 'LIKE', '%' . $search . '%')
                    ->orWhere('publisher_company_nit', 'LIKE', '%' . $search . '%')
                    ->orWhere('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%')
                    ->orWhere('tags', 'LIKE', '%' . $search . '%')
                    ->orWhere('address', 'LIKE', '%' . $search . '%');
            });
        }

        return $query->orderBy('view_spaces.created_at', 'desc')->get();
    }

    public function query(&$query, $data, $columnSearch, $search)
    {
        if (array_key_exists($columnSearch, $data) && (! empty($data[$columnSearch] || $data[$columnSearch] == "0"))) {
            $query->where($search, '=', $data[$columnSearch]);
        }
    }
}