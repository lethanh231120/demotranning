<?php

namespace App\Services;


class ImageService
{

    /**
     * Upload image.
     *
     * @param  file $file
     * @param  string $dir
     * @return Object
     */
    public function uploadImage($file, $avt)
    {
        if (!is_null($file)) {
            $path = $file->move("upload/{$avt}/", $file->getClientOriginalName());
            return $path;
        }
        return null;
    }
}
