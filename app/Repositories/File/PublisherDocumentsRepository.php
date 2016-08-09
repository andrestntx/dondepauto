<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 12/07/2016
 * Time: 6:22 PM
 */

namespace App\Repositories\File;


use App\Entities\Platform\User;
use Illuminate\Http\UploadedFile;

class PublisherDocumentsRepository extends BaseRepository
{
    protected $path = "documents/publishers";

    protected $documents = ['bank' => 'certificación bancaria', 'commerce' => 'cámara de comercio', 'letter' => 'acuerdo', 'rut' => 'rut'];


    /**
     * @param $id
     * @return string
     */
    public function getPathId($id)
    {
        return $this->getPath() . '/' . $id;
    }

    /**
     * @param User $publisher
     * @return string
     */
    public function getPathPublisher(User $publisher)
    {
        return $this->getPathId($publisher->id);
    }

    /**
     * @return string
     */
    public function getTerms()
    {
        return $this->getPath() . '/terms.pdf';
    }

    /**
     * @param $id
     * @return mixed
     */
    public function hasFilesId($id)
    {
        return \File::exists($this->getPathId($id) . '/bank.pdf');
    }

    /**
     * @param User $publisher
     * @return mixed
     */
    public function hasFiles(User $publisher)
    {
        return \File::exists($this->getPathPublisher($publisher) . '/bank.pdf');
    }

    /**
     * @param $id
     * @param $name
     * @return string
     */
    public function getDocumentId($id, $name)
    {
        return $this->getPathId($id) . '/'. $name .'.pdf';
    }

    /**
     * @param User $publisher
     * @param $name
     * @return string
     */
    public function getDocument(User $publisher, $name)
    {
        return $this->getDocumentId($publisher->id, $name);
    }

    /**
     * @param $id
     * @return array
     */
    public function getDocumentsId($id)
    {
        $files = [];

        if($this->hasFilesId($id)) {
            foreach($this->documents as $key => $name) {
                $files[$key] = [
                    'name' => $name,
                    'url'  => $this->getDocumentId($id, $key)
                ];
            }
        }

        return $files;
    }

    /**
     * @param User $publisher
     * @return array
     */
    public function getDocuments(User $publisher)
    {
        return $this->getDocumentsId($publisher->id);
    }

    /**
     * @param User $publisher
     * @param UploadedFile $document
     * @param $name
     * @return null|\Symfony\Component\HttpFoundation\File\File
     */
    protected function saveDocument(User $publisher, UploadedFile $document, $name)
    {
        return $this->isValidMove($document, $this->getPathPublisher($publisher), $name . '.pdf');
    }

    /**
     * @param User $publisher
     * @param UploadedFile $document
     * @return null|\Symfony\Component\HttpFoundation\File\File
     */
    public function saveCommerceDocument(User $publisher, UploadedFile $document)
    {
        return $this->saveDocument($publisher, $document, 'commerce');
    }

    /**
     * @param User $publisher
     * @param UploadedFile $document
     * @return null|\Symfony\Component\HttpFoundation\File\File
     */
    public function saveBankDocument(User $publisher, UploadedFile $document)
    {
        return $this->saveDocument($publisher, $document, 'bank');
    }

    /**
     * @param User $publisher
     * @param UploadedFile $document
     * @return null|\Symfony\Component\HttpFoundation\File\File
     */
    public function saveRutDocument(User $publisher, UploadedFile $document)
    {
        return $this->saveDocument($publisher, $document, 'rut');
    }

    /**
     * @param User $publisher
     * @param UploadedFile $document
     * @return null|\Symfony\Component\HttpFoundation\File\File
     */
    public function saveLetterDocument(User $publisher, UploadedFile $document)
    {
        return $this->saveDocument($publisher, $document, 'letter');
    }

    /**
     * @param User $publisher
     * @param $dateString
     * @return mixed
     */
    public function generateLetter(User $publisher, $dateString)
    {
        $publisher->load('representative');

        if(! \File::exists($this->getPathPublisher($publisher))) {
            \Storage::makeDirectory($this->getPathPublisher($publisher));
        }

        $stream = \PDF::loadView('pdf.letter', ['publisher' => $publisher, 'date' => $dateString])
            ->setPaper('a4')
            ->save($this->getPathPublisher($publisher) . '/letter-generated.pdf')
            ->stream('carta_dondepauto.pdf');

        return ['stream' => $stream, 'path' => $this->getDocument($publisher, 'letter-generated')];
    }
}