<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:21 AM
 */

namespace App\Repositories\Platform;


use App\Entities\Platform\User;
use App\Repositories\BaseRepository;

class ActionRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\Platform\Action';
    }

    private function getDefaultStates()
    {
        return [
            'En aprobación' => 'En aprobación',
            'Enviada' => 'Enviada',
            'En construcción' => 'En construcción'
        ];
    }

    /**
     * @return mixed
     */
    public function statesWithProposals()
    {
        $states = $this->model
            ->join('action_contact', 'action_contact.action_id', '=', 'actions.id')
            ->join('contacts', 'action_contact.contact_id', '=', 'contacts.id')
            ->join('proposals', function($join) {
                return $join->on('contacts.proposal_id', '=', 'proposals.id')
                    ->whereNull('proposals.deleted_at');
            })
            ->where('actions.state', '<>', '')
            ->groupBy('actions.state')
            ->lists('actions.state', 'actions.state')
            ->all();

        return array_merge($states, $this->getDefaultStates());
    }

    protected function listsOfType($type = 'advertiser')
    {
        return $this->model
            ->ofUser($type)
            ->orderBy('order')
            ->lists('name', 'id')
            ->all();
    }

    public function listsOfProposal()
    {
        return $this->model
            ->with('contacts')
            ->where(function($query) {
                return $query->where('type', 'proposal')
                    ->orWhere('type', 'all');
            })
            ->orderBy('order')
            ->lists('name', 'id')
            ->all();
    }

    /**
     * @return mixed
     */
    public function listsAdvertiser()
    {
        return $this->listsOfType();
    }

    /**
     * @return mixed
     */
    public function listsPublisher()
    {
        return $this->listsOfType('publisher');
    }
}