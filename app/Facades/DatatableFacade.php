<?php
/**
 * Created by PhpStorm.
 * User: andrestntx
 * Date: 10/11/16
 * Time: 2:06 PM
 */

namespace App\Facades;


use App\Entities\Platform\User;
use App\Entities\Proposal\Proposal;
use Illuminate\Database\Eloquent\Collection;

class DatatableFacade
{
    protected $publisherFacade;
    protected $spaceFacade;
    protected $advertiserFacade;
    protected $proposalFacade;


    /**
     * DatatableFacade constructor.
     * @param PublisherFacade $publisherFacade
     * @param AdvertiserFacade $advertiserFacade
     * @param SpaceFacade $spaceFacade
     * @param ProposalFacade $proposalFacade
     */
    public function __construct(PublisherFacade $publisherFacade, AdvertiserFacade $advertiserFacade, SpaceFacade $spaceFacade,
        ProposalFacade $proposalFacade)
    {
        $this->publisherFacade = $publisherFacade;
        $this->advertiserFacade = $advertiserFacade;
        $this->spaceFacade = $spaceFacade;
        $this->proposalFacade = $proposalFacade;
    }

    /**
     * @param array $columns
     * @return array
     */
    private function getDataColumns(array $columns)
    {
        $data = [];

        foreach($columns as $column) {
            $data[$column['name']] = trim($column['search']['value']);
        }

        return $data;
    }

    /**
     * @param $input
     * @return mixed
     */
    private function getOrder($input)
    {
        return $input['order'][0];
    }

    /**
     * @param $input
     * @return mixed
     */
    private function getOrderColumn($input)
    {
        return $this->getOrder($input)['column'];
    }

    /**
     * @param $input
     * @return bool
     */
    private function getOrderDescending($input)
    {
        if($this->getOrder($input)['dir'] == 'asc') {
            return false;
        }

        return true;
    }

    /**
     * @param $input
     * @param array $columns
     * @return mixed
     */
    private function getOrderColumnName($input, array $columns)
    {
        return $columns[$this->getOrderColumn($input)]['data'];
    }

    /**
     * @param Collection $collection
     * @param $column
     * @param bool $descending
     * @return static
     */
    private function orderCollection(Collection $collection, $column, $descending = false)
    {
        return $collection->sortBy($column, null, $descending);
    }

    /**
     * @param Collection $collection
     * @param $items
     * @param $input
     * @param array $columns
     * @return mixed
     */
    private function getJsonResponse(Collection $collection, $items, $input, array $columns)
    {
        $collection = $this->orderCollection($collection, $this->getOrderColumnName($input, $columns), $this->getOrderDescending($input));
        $length = $this->getLength(intval($input['length']));
        $page = $this->getPage(intval($input['start'], $length));

        return [
            "draw"          => $input['draw'],
            "recordsTotal"  => $collection->count(),
            "recordsFiltered" => $collection->count(),
            "data"          => array_values($collection->forPage($page, $length)->all()),
            "input"         => $input
        ];
    }

    private function getLength($length = 20)
    {
        return ($length <= 20) ? $length : 20;
    }

    private function getPage($start = 0, $length = 20)
    {
        $page = 1;

        if($start > 0) {
            $page = ($start / $length) + 1;
        }

        return $page;
    }

    /**
     * @param array $columns
     * @param string $search
     * @param array $input
     * @return mixed
     */
    public function searchPublishers(array $columns, $search = '', array $input)
    {
        $publishers = $this->publisherFacade->searchAndFilter($this->getDataColumns($columns), $search);
        return $this->getJsonResponse($publishers, 100, $input, $columns);
    }


    /**
     * @param User|null $user
     * @param array $columns
     * @param string $search
     * @param $init
     * @param $finish
     * @param array $inputs
     * @return mixed
     */
    public function searchAdvertisers(User $user = null, array $columns, $search = '', $init, $finish, array $inputs)
    {
        $advertisers = $this->advertiserFacade->searchAndFilter($user, $this->getDataColumns($columns), $search, $init, $finish);

        return $this->getJsonResponse($advertisers, 100, $inputs, $columns);
    }

    /**
     * @param array $columns
     * @param string $search
     * @param null $spaceId
     * @param User|null $publisher
     * @param Proposal|null $proposal
     * @param array $inputs
     * @return mixed
     */
    public function searchSpaces(array $columns, $search = '', $spaceId = null, User $publisher = null, Proposal $proposal = null, array $inputs)
    {
        $spaces = $this->spaceFacade->searchAndFilter($this->getDataColumns($columns), $search, $spaceId, $publisher, $proposal);
        return $this->getJsonResponse($spaces, 100, $inputs, $columns);
    }

    /**
     * @param array $columns
     * @param string $search
     * @param array $inputs
     * @return mixed
     */
    public function searchProposals(array $columns, $search = '', array $inputs, $publisher = null)
    {
        $proposals = $this->proposalFacade->searchAndFilter($this->getDataColumns($columns), $search, $publisher);
        
        return array_merge($this->getJsonResponse($proposals, 100, $inputs, $columns), [
            'total_price' => $proposals->sum('pivot_total'),
            'total_income' => $proposals->sum('pivot_total_income_price')
        ]);
    }
}