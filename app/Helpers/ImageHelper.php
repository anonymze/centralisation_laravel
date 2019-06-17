<?php

namespace App\Helpers;
use Carbon\Carbon;

class ImageHelper
{
    public static function formatImage($attribute_image)
    {
        $name_image = Carbon::now()->format('Y-m-d-H-i-s') . '.' . $attribute_image->getClientOriginalExtension();
        $destination_path = 'public/images';

        $attribute_image->move($destination_path, $name_image);
        $attribute_image = asset($destination_path . '/' . $name_image);

        return $attribute_image;
    }

}