<?php
/**
 * Created by PhpStorm.
 * User: konstantinkuznecov
 * Date: 7/30/21
 * Time: 1:53 PM
 */

namespace App\Services;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;


class ImageService {

    private $imageSize = 2097152;

    /**
     * Сhecking and saving the image.
     *
     * @param  string  $fileName
     * @return bool
     */

    public function saveImageToStorage($fileName){

        if (Cache::has('fileName')) {
            Cache::forget('fileName');
        }
        $name = basename($fileName);
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        if(!Storage::disk('public')->exists('/img/' . $name)) {
            $name = uniqid() . '.'  . $ext;
            Storage::disk('public')->put('/img/' . $name, file_get_contents($fileName));
            $size = Storage::disk('public')->size('/img/' . $name);
            if($size > $this->imageSize){
                Storage::disk('public')->delete('/img/' . $name);
                return false;
            } else {
                Cache::put('fileName', $name);
            }
        }
        return true;

    }

}