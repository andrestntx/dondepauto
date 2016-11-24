<?php
/**
 * Created by PhpStorm.
 * User: andrestntx
 * Date: 10/11/16
 * Time: 2:33 PM
 */

namespace App\Services;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class FilterCollectionService
{
    /**
     * @param $search
     * @return bool
     */
    private function isSearch($search)
    {
        return ! empty($search);
    }

    /**
     * @param $search
     * @param $value
     * @return bool
     */
    private function isEqual($search, $value)
    {
        if($this->isSearch($search) && $search != $value) {
            return false;
        }

        return true;
    }

    /**
     * @param $search
     * @param $value
     * @return bool
     */
    private function notIs($search, $value)
    {
        if(! $this->isSearch($search) || $search == $value) {
            return false;
        }

        return true;
    }

    /**
     * @param $search
     * @return bool
     */
    private function isDateRange($search)
    {
        if($this->isSearch($this->getDateRange($search)[0]) || $this->isSearch($this->getDateRange($search)[0])){
            return true;
        }

        return false;
    }

    /**
     * @param $search
     * @param $value
     * @return bool
     */
    private function isTrue($search, $value)
    {
        if($this->isSearch($search) && ! $value) {
            return false;
        }

        return true;
    }

    /**
     * @param $search
     * @param $equal
     * @param $value
     * @return bool
     */
    private function isEqualAndTrue($search, $equal, $value)
    {
        if($this->isSearch($search)) {
            return $this->isEqual($search, $equal) && $value;
        }

        return true;
    }

    /**
     * @param $search
     * @param array $values
     * @return bool
     */
    private function isEqualsAndTrue($search, array $values)
    {
        foreach($values as $equal => $value) {
            if($this->isEqualAndTrue($search, $equal, $value)) {
                return true;
            }
        }

        return false;
    }


    /**
     * @param $date
     * @return int
     */
    private function getDateStrtotime($date)
    {
        if($this->isSearch($date)){
            return strtotime(Carbon::createFromFormat('d/m/Y', $date)->toDateString());
        }

        return '';
    }

    /**
     * @param $date1
     * @param $date2
     * @param $date
     * @return bool
     */
    private function inDateRange($date1, $date2, $date)
    {
        if( $this->isSearch($date1) &&  $this->isSearch($date2)) {
            return $date >= $date1 && $date <= $date2;
        }
        else if( $this->isSearch($date1)) {
            return $date >= $date1;
        }
        else {
            return $date <= $date2;
        }
    }

    /**
     * @param $range
     * @return array
     */
    private function getDateRange($range)
    {
        $range = explode(',', $range);

        if(count($range) == 2) {
            return $range;
        }
        else if(count($range) == 1) {
            return [$range[0], ''];
        }
        else {
            return ['', ''];
        }
    }

    /**
     * @param $search
     * @param $date
     * @return bool
     */
    private function inDateRangeSearch($search, $date)
    {
        if($this->isDateRange($search)) {
            $dateRange = explode(',', $search);
            return $this->inDateRange($this->getDateStrtotime($dateRange[0]), $this->getDateStrtotime($dateRange[1]), strtotime($date));
        }

        return true;
    }

    /**
     * @param $search
     * @param $date
     * @param $value
     * @return bool
     */
    private function inDateRangeAndTrue($search, $date, $value)
    {
        if($this->isDateRange($search)) {
            return $this->inDateRangeSearch($search, $date) && $value;
        }

        return true;
    }

    private function isDateRangeAndTrue($search, $value)
    {
        if($this->isDateRange($search) && ! $value) {
            return false;
        }

        return true;
    }

    /**
     * @param $user
     * @param array $data
     * @return bool
     */
    private function userHasActions($user, array $data)
    {
        if( $this->notIs($data['action'], "0") || $this->isSearch($data['action_range'])) {

            if($lastAction = $user->getLastAction()) {
                return $lastAction->isActionAndIsInRange($data['action'], $this->getDateRange($data['action_range'])[0], $this->getDateRange($data['action_range'])[1]);
            }

            return false;
        }

        return true;
    }

    /**
     * @param $user
     * @param array $data
     * @return bool
     */
    private function filterUser($user, array $data)
    {
        return $this->isTrue($data['state_id'], $user->hasState($data['state_id'])) &&
                $this->isEqual($data['tag_id'], $user->tag_id) &&
                $this->userHasActions($user, $data);
    }


    /**
     * @param Collection $publishers
     * @param array $data
     * @return Collection
     */
    public function filterPublisherCollection(Collection $publishers, array $data)
    {
        return $publishers->filter(function ($publisher) use ($data) {
            $cities     = $this->isTrue($data['space_city_names'],  $publisher->hasSpaceCity(intval($data['space_city_names'])));
            $hasLogo    = $this->isEqualsAndTrue($data['has_logo'], ['true' => $publisher->has_logo, 'false' =>  ! $publisher->has_logo]);
            $dates      = $this->inDateRangeAndTrue($data['last_offer_at_datatable'], $publisher->last_offer_date, $publisher->hasState('offers'));
            $agreement  = $this->isDateRangeAndTrue($data['signed_at_datatable'], $publisher->hasState('agreement'));

            return $cities && $dates && $hasLogo && $agreement && $this->filterUser($publisher, $data);
        });
    }

    /**
     * @param Collection $advertisers
     * @param array $data
     * @return Collection
     */
    public function filterAdvertiserCollection(Collection $advertisers, array $data)
    {
        return $advertisers->filter(function ($advertiser) use ($data) {
            return $this->isTrue($data['intention_at'], $advertiser->intentions->count() > 0) &&
                    $this->filterUser($advertiser, $data);
        });
    }

    /**
     * @param Collection $spaces
     * @param array $data
     * @return Collection
     */
    public function filterSpaceCollection(Collection $spaces, array $data)
    {
        return $spaces->filter(function ($space) use ($data) {
            return $this->isTrue($data['city_id'], $space->hasCity(intval($data['city_id']))) &&
                $this->isTrue($data['impact_scene_id'], $space->hasImpactScene(intval($data['impact_scene_id'])));
        });
    }
}