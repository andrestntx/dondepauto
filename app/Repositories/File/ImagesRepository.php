<?php

namespace App\Repositories\File;

use Intervention\Image\Image;

/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 28/06/2016
 * Time: 10:43 AM
 */
class ImagesRepository extends BaseRepository
{
    /**
     * @param \Intervention\Image\Image $image
     * @param $path
     * @return \Intervention\Image\Image
     */
    protected function saveImage(Image $image, $path)
    {
        return $image->save($path);
    }

    /**
     * @param \Intervention\Image\Image $image
     * @param $name
     * @return \Intervention\Image\Image
     */
    protected function saveImagePath(Image $image, $name)
    {
        return $this->saveImage($image, $this->getMorePath($name));
    }

    /**
     * @param \Intervention\Image\Image $image
     * @param $path
     * @param $name
     * @return \Intervention\Image\Image
     */
    protected function saveImageMorePath(Image $image, $path, $name)
    {
        return $this->saveImagePath($image, $path . '/' . $name);
    }

    /**
     * @param Image $image
     * @param $width
     * @return Image
     */
    protected function resizeWidthProportional(Image $image, $width)
    {
        return $image->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
    }

    /**
     * @param Image $image
     * @param $height
     * @return Image
     */
    protected function resizeHeightProportional(Image $image, $height)
    {
        return $image->resize(null, $height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
    }
}