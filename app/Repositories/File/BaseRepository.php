<?php

namespace App\Repositories\File;

/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 28/06/2016
 * Time: 10:32 AM
 */

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class BaseRepository
{
    protected $path;

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param $path
     * @return string
     */
    public function getMorePath($path)
    {
        return $this->getPath() . '/' . $path;
    }

    /**
     * @param UploadedFile $file
     * @param $path
     * @param $name
     * @return null|\Symfony\Component\HttpFoundation\File\File
     */
    public function isValidMove(UploadedFile $file = null, $path, $name)
    {
        if(! is_null($file) && $file->isValid()) {
            return $file->move($path, $name);
        }

        return null;
    }

    /**
     * @param UploadedFile $file
     * @param $name
     * @return null|\Symfony\Component\HttpFoundation\File\File
     */
    public function saveFile(UploadedFile $file, $name)
    {
        return $this->isValidMove($file, $this->getPath(), $name);
    }

    /**
     * @param $path
     * @param UploadedFile $file
     * @param $name
     * @return null|\Symfony\Component\HttpFoundation\File\File
     */
    public function saveFilePath($path, UploadedFile $file, $name)
    {
        return $this->isValidMove($file, $this->getMorePath($path), $name);
    }

    /**
     * @param $urlFile
     * @param $urlDefault
     * @return string
     */
    public function getFileOrDefault($urlFile, $urlDefault)
    {
        if(! Storage::exists($urlFile)) {
            $urlFile = $urlDefault;
        }

        return '/' . $urlFile;
    }
}
