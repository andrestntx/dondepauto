<?php
/**
 * Created by PhpStorm.
 * User: andrestntx
 * Date: 9/20/16
 * Time: 4:10 PM
 */

namespace App\Services;


use App\Entities\Proposal\Quote;
use App\Repositories\Proposal\QuoteRepository;

class QuoteService
{

    protected $repository;

    /**
     * QuoteService constructor.
     * @param $repository
     */
    public function __construct(QuoteRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Quote $quote
     * @param array $data
     * @param array $questions
     * @return Quote
     */
    public function update(Quote $quote, array $data, array $questions)
    {
        $quote->fill($data);
        $quote->save();
        $this->addQuestions($this->removeRelations($quote), $questions);
        \Log::info($data['cities']);
        \Log::info($quote->cities);
        return $this->addCities($quote, $data['cities']);
    }

    /**
     * @param Quote $quote
     * @return Quote
     */
    protected function removeRelations(Quote $quote)
    {
        return $this->removeCities($this->removeQuestions($quote));
    }

    /**
     * @param Quote $quote
     * @return Quote
     */
    protected function removeQuestions(Quote $quote)
    {
        $quote->questions()->detach();
        return $quote;
    }

    /**
     * @param Quote $quote
     * @return Quote
     */
    protected function removeCities(Quote $quote)
    {
        $quote->cities()->detach();
        return $quote;
    }

    /**
     * @param Quote $quote
     * @param array $questions
     * @return Quote
     */
    public function addQuestions(Quote $quote, array $questions)
    {
        $quote->questions()->attach($this->cleanArrayQuestions($questions));
        return $quote;
    }

    /**
     * @param Quote $quote
     * @param array $cities
     * @return Quote
     */
    public function addCities(Quote $quote, array $cities)
    {
        $quote->cities()->attach($cities);
        return $quote;
    }

    /**
     * @param Quote $quote
     * @param array $audiences
     * @return Quote
     */
    public function addAudiences(Quote $quote, array $audiences)
    {
        $quote->audiences()->attach($audiences);
        return $quote;
    }

    /**
     * @return mixed
     */
    public function search()
    {
        return $this->repository->search();
    }

    /**
     * @param array $questions
     * @return array
     */
    protected function cleanArrayQuestions(array $questions)
    {
        $array = [];

        foreach($questions as $id => $answer) {
            $array[$id] = ['answer' => $answer];
        }

        return $array;
    }
}