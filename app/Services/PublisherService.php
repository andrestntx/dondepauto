<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 11:50 AM
 */

namespace App\Services;

use App\Entities\Platform\User;
use App\Repositories\File\LogosRepository;
use App\Repositories\File\PublisherDocumentsRepository;
use App\Repositories\Platform\UserRepository;
use App\Repositories\Views\PublisherRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class PublisherService extends ResourceService
{
    protected $viewRepository;
    protected $publisherDocumentsRepository;
    protected $logosRepository;

    /**
     * UserService constructor.
     * @param PublisherRepository $viewRepository
     * @param UserRepository $repository
     * @param PublisherDocumentsRepository $publisherDocumentsRepository
     * @param LogosRepository $logosRepository
     */
    function __construct(PublisherRepository $viewRepository, UserRepository $repository,
                         PublisherDocumentsRepository $publisherDocumentsRepository, LogosRepository $logosRepository)
    {
        $this->viewRepository = $viewRepository;
        $this->repository = $repository;
        $this->publisherDocumentsRepository = $publisherDocumentsRepository;
        $this->logosRepository = $logosRepository;
    }
    
    /**
     * @param array $columns
     * @param $search
     * @return mixed
     */
    public function search(array $columns, $search)
    {
        return $this->viewRepository->search($columns, $search);
    }

    /**
     * @param array $data
     * @param Model $publisher
     * @return mixed
     */
    public function completeData(array $data, Model $publisher)
    {
        $data['complete_data'] = true;
        $data['completed_at'] = Carbon::now()->toDateTimeString();

        return $this->updateModel($data, $publisher);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createModel(array $data)
    {
        $data['source'] = 'CRM Interno';
        $data['role'] = 'publisher';
        $data['complete_data'] = false;

        if($publisher = $this->findDelete('email_us_LI', $data['email'])) {
            $this->restoreModel($publisher);
            return $this->repository->update($data, $publisher);
        }

        return $this->repository->create($data);
    }


    /**
     * @param null $category_id
     * @param null $subCategory_id
     * @param null $format_id
     * @param null $city_id
     * @param null $scene_id
     * @return mixed
     */
    public function searchWithSpaces($category_id = null, $subCategory_id = null, $format_id = null, $city_id = null, $scene_id = null)
    {
        return $this->viewRepository->publishersWithSpaces($category_id, $subCategory_id, $format_id, $city_id, $scene_id);
    }

    /**
     * @param $publisher
     * @return mixed
     */
    public function getSpaces($publisher)
    {
        return $this->repository->getSpaces($publisher);
    }

    /**
     * @param array $data
     * @param null $password
     * @return mixed
     */
    public function register(array $data, $password = null)
    {
        if(! is_null($password)) {
            $data['password'] = $password;
        }

        return $this->createModel($data);
    }


    /**
     * @param User $publisher
     * @param UploadedFile $commerceDocument
     * @param UploadedFile $rutDocument
     * @param UploadedFile $bankDocument
     * @param UploadedFile $letterDocument
     */
    public function saveDocuments(User $publisher, UploadedFile $commerceDocument = null, UploadedFile $rutDocument = null, UploadedFile $bankDocument = null, UploadedFile $letterDocument = null)
    {
        $this->publisherDocumentsRepository->saveCommerceDocument($publisher, $commerceDocument);
        $this->publisherDocumentsRepository->saveRutDocument($publisher, $rutDocument);
        $this->publisherDocumentsRepository->saveBankDocument($publisher, $bankDocument);
        $this->publisherDocumentsRepository->saveLetterDocument($publisher, $letterDocument);
    }

    /**
     * @param User $publisher
     * @param $dateString
     * @return mixed
     */
    public function generateLetter(User $publisher, $dateString)
    {
        return $this->publisherDocumentsRepository->generateLetter($publisher, $dateString);
    }

    /**
     * @return string
     */
    public function getTerms()
    {
        return $this->publisherDocumentsRepository->getTerms();
    }

    public function findOrCreateUser(User $publisher)
    {
        if(! $publisher->user) {
            $this;
        }

        dd($publisher->user);
    }

    /**
     * @param User $publisher
     * @return bool
     */
    public function changeRole(User $publisher)
    {
        return $this->repository->changeRole($publisher, 'publisher');
    }

    /**
     * @param User $user
     * @param $agreement
     * @return bool
     */
    public function setAgreement(User $user, $agreement)
    {
        return $this->repository->setAgreement($user, $agreement);
    }

    /**
     * @param User $publisher
     * @param $changeDocuments
     */
    public function setChangeDocuments(User $publisher, $changeDocuments)
    {
        $this->repository->setChangeDocuments($publisher, $changeDocuments);
    }

    /**
     * @param User $user
     * @param UploadedFile $logo
     */
    public function saveLogo(User $user, UploadedFile $logo)
    {
        $this->logosRepository->save($user, $logo);
    }

    /**
     * @param User $publisher
     * @return mixed
     */
    public function confirm(User $publisher)
    {
        return $this->repository->confirm($publisher);
    }

    /**
     * @param User $publisher
     * @return mixed
     */
    public function getPublisherView(User $publisher)
    {
        return $this->getPublisherViewId($publisher->id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getPublisherViewId($id)
    {
        return $this->viewRepository->getPublisher($id);
    }

    /**
     * @param $id
     * @return array
     */
    public function getStates($id)
    {
        return $this->viewRepository->getStates($id);
    }



}