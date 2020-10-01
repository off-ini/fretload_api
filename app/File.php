<?php

namespace App;

use Exception;
use Intervention\Image\Facades\Image;

class File
{
    public static function write($image)
    {
        if($image != null)
        {
            try{
                $img = $image;
                $name = time().'.'.explode('/', explode(':', substr($img, 0, strpos($img, ';')))[1])[1];
                Image::make($image)->save(public_path('images/'.$name));
                return $name;
            }catch(Exception $e)
            {
                return null;
            }

        }
        return null;
    }

    public static function delete($image)
    {

    }
}
