<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class MediaController extends Controller
{
    public $width = 300;
    public $height = 300;

    public function getImage(Request $request)
    {
        try {
            $image = $request->img ?? 'default.jpg';

            if ($request->w) {
                $this->width = $request->w;
            }

            if ($request->h) {
                $this->width = $request->h;
            }

            $img = Image::make( public_path( 'images/' . $image ) );

            $img->resize( $this->width, $this->height );

            return $img->response( $img->extension );

        } catch (\Exception $e) {
            return $e->getMessage();
        }


    }

}
