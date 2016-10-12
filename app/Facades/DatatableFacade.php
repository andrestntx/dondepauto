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


    /**
     * DatatableFacade constructor.
     * @param PublisherFacade $publisherFacade
     * @param AdvertiserFacade $advertiserFacade
     * @param SpaceFacade $spaceFacade
     */
    public function __construct(PublisherFacade $publisherFacade, AdvertiserFacade $advertiserFacade, SpaceFacade $spaceFacade)
    {
        $this->publisherFacade = $publisherFacade;
        $this->advertiserFacade = $advertiserFacade;
        $this->spaceFacade = $spaceFacade;
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
     * @param Collection $collection
     * @param $items
     * @param $input
     * @return mixed
     */
    private function getJsonResponse(Collection $collection, $items, $input)
    {
        if($input['start'] == 0) {
            $page = 1;
        }
        else {
            $page = ($input["length"] / $input['start']) + 1;
        }

        return [
            "draw"          => $input['draw'],
            "recordsTotal"  => $collection->count(), "recordsFiltered" => $collection->count(),
            "data"          => array_values($collection->forPage($page, $input["length"])->toArray()),
            "input"         => $input
        ];
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
        return $this->getJsonResponse($publishers, 100, $input);
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
        return $this->getJsonResponse($advertisers, 100, $inputs);
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
        return $this->getJsonResponse($spaces, 100, $inputs);
    }
}