<?php
/**
 * Created by PhpStorm.
 * Users: Desarrollador 1
 * Date: 13/04/2016
 * Time: 10:26 AM
 */

namespace App\Repositories\Proposal;

use App\Entities\Platform\Space\Space;
use App\Entities\Platform\User;
use App\Entities\Proposal\Proposal;
use App\Repositories\BaseRepository;

class ProposalRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\Proposal\Proposal';
    }

    /**
     * @param User $advertiser
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search(User $advertiser = null)
    {
        return $this->model->with([
            'quote.advertiser',
            'viewSpaces',
            'viewSpaces.audiences.type',
            'viewSpaces.impactScenes',
            'viewSpaces.cities',
            'spaces'
        ])->get();
    }

    /**
     * @param null $spaceId
     * @param array $columns
     * @return mixed
     */
    public function searchSpaces($spaceId = null, array $columns = [])
    {
        $query = $this->model->whereIsDelete(0)->with(['images']);

        if(!is_null($publisher)) {
            $query->wherePublisherId($publisher->id);
        }
        if(!is_null($spaceId)){
            $query->whereId($spaceId);
        }

        foreach ($columns as $column) {
            if ($column['name'] == 'impact_scene_id' && trim($column['search']['value'])) {
                $query->where('impact_scene_id', '=', $column['search']['value']);
            }
        }

        return $query->orderBy('created_at', 'desc');
    }


    /**
     * @param Proposal $proposal
     * @param $id
     * @param array $data
     * @return int
     */
    protected function updateSpace(Proposal $proposal, $id, array $data)
    {
        return $proposal->spaces()->updateExistingPivot($id, $data);
    }

    /**
     * Edit the pivot attributes of proposal_space table
     *
     * @param Proposal $proposal
     * @param Space $space
     * @param array $data
     * @return array
     */
    public function sync(Proposal $proposal, Space $space, array $data)
    {
        return $this->updateSpace($proposal, $space->id, $data);
    }


    /**
     * @param Proposal $proposal
     * @param Space $space
     * @param int $select
     */
    public function selectSpace(Proposal $proposal, Space $space, $select = 0)
    {
        $this->sync($proposal, $space, ['selected' => $select]);
    }


    /**
     * @param Proposal $proposal
     * @param array $spaceIds
     * @param array $data
     * @return mixed
     */
    public function syncSpaces(Proposal $proposal, array $spaceIds, array $data)
    {
        foreach($spaceIds as $id) {
            $this->updateSpace($proposal, $id, $data);
        }

        return $proposal->spaces;
    }


    /**
     * @param Proposal $proposal
     * @param array $spacesId
     * @return array
     */
    public function getSpacesIdNotIn(Proposal $proposal, array $spacesId)
    {
        $ids = [];
        $collection = $proposal->viewSpaces()->whereNotIn("view_spaces.id", $spacesId)->select("view_spaces.id")->get("id");
        foreach ($collection as $item) {
            array_push($ids, $item->id);
        }

        return $ids;
    }

}