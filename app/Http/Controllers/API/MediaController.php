<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\MediaRequest;
use App\Media;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class MediaController extends Controller
{
    public $width = 300;
    public $height = 300;
    public $baseUpload = 'images/';

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

            $img = Image::make( public_path( $this->baseUpload . $image ) );

            $img->resize( $this->width, $this->height );

            return $img->response( $img->extension );

        } catch (\Exception $e) {
            return $e->getMessage();
        }


    }

    public function upload(MediaRequest $request)
    {
        $file = $request->file;
        if (is_file( $file )) {
            $image['original_name'] = $file->getClientOriginalName();
            $image['size'] = $file->getSize();
            $image['mime_type'] = $file->getMimeType();
            $image['ext'] = $file->getClientOriginalExtension();;
            $now = DateTime::createFromFormat( 'U.u', microtime( true ) );
            $fileName = $now->format( "d_H_i_s_u" );

            $this->isFile( $image['mime_type'] );

            $image['file_name'] = $fileName . '.' . $image['ext'];

            $file->move( $this->baseUpload, $image['file_name'] );

            return Media::create( $image );
        }

    }

    public function delete($files)
    {
        $files = explode( ',', $files );
        foreach ($files as $file) {
            $file = Media::findOrfail( $file );
            $this->isFile( $file->mime_type );
            $fileName = $this->baseUpload . $file->file_name;
            if (file_exists( $fileName )) {
                @unlink( public_path( $fileName ) );
            }
            $file->delete();
        }

        return response()->json( ['result' => 'Delete successfull'] );
        //return true;
    }

    private function isFile($file)
    {
        if (substr( $file, 0, 5 ) !== 'image') {
            $this->baseUpload = 'files/';
        }
    }


}
