<?php

namespace App\Repositories\File;

use App\Entities\Platform\Space\Space;
use App\Entities\Platform\Space\SpaceImage;
use App\Entities\Platform\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Image;

/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 28/06/2016
 * Time: 10:43 AM
 */
class LogosRepository extends ImagesRepository
{
    protected $path = "logos";
    protected $logoDefault = "assets/img/dashboard/upload-logo.png";

    /**
     * @param $id
     * @return string
     */
    public function getPathId($id)
    {
        return $this->getMorePath($id);
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
     * @param User $publisher
     * @return string
     */
    public function getLogo(User $publisher)
    {
        return $this->getPathPublisher($publisher) . '/logo.jpg';
    }

    /**
     * @param User $publisher
     * @param UploadedFile $photoFile
     * @param int $size
     * @return Image
     */
    function save(User $publisher, UploadedFile $photoFile, $size = 500)
    {
        $image = \Image::make($photoFile);

        if(! \File::exists($this->getPathPublisher($publisher))) {
            \Storage::makeDirectory($this->getPathPublisher($publisher));
        }

        return $this->saveImage($this->resizeWidthProportional($image, $size), $this->getLogo($publisher));
    }

    /**
     * @param User $publisher
     * @return string
     */
    function getLogoUrl(User $publisher)
    {
        return $this->getFileOrDefault($this->getLogo($publisher), $this->logoDefault);
    }

    /**
     * @param User $publisher
     * @return mixed
     */
    public function hasLogo(User $publisher)
    {
        return $this->hasUploadedFile($this->getLogo($publisher));
    }
}