<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    public function getImageByDate($type, $year, $month, $image){
//        $path = config('app.storage').'/'.$type.'/'.$image;
//        if (file_exists($path)) {
//            return Response::download($path);
//        }

        /// Another way, better way
        $path = config('app.storage').'/'.urldecode($type).'/'.$year.'/'.$month.'/'.urldecode($image);
        if(file_exists($path)){
            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);

            return $response;
        }else{
            $path = config('app.storage').'/no_image.png';
            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);

            return $response;
        }
    }

    public function getImage($image){
        /// Another way, better way
        $path = config('app.storage').'/'.urldecode($image);
        if(file_exists($path)){
            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);

            return $response;
        }

            return \response(["message"=>"error file doesn't exist"],404);
    }



    public function getThumb( $image, $size=100){
        $path = config('app.storage').'/'.$image;
        if(file_exists($path)){
            $file = File::get($path);
            $type = File::mimeType($path);

            $img = Image::make($path);
            $img = $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            return $img->response('jpg');
        }else{
            $path = config('app.storage').'/no_image.png';
            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);

            return $response;
        }
    }

    public function getVideo($type=null, $id = null){
        $path = config('app.storage').'/'.$type.'/'.$id;
        if (file_exists($path)) {
            return Response::download($path);
        }
    }

//    public function resize($imagePath, $width, $height, $filterType, $blur, $bestFit, $cropZoom){
//        //The blur factor where &gt; 1 is blurry, &lt; 1 is sharp.
//        $imagick = new \Imagick(realpath($imagePath));
//
//        $imagick->resizeImage($width, $height, $filterType, $blur, $bestFit);
//
//        $cropWidth = $imagick->getImageWidth();
//        $cropHeight = $imagick->getImageHeight();
//
//        if ($cropZoom) {
//            $newWidth = $cropWidth / 2;
//            $newHeight = $cropHeight / 2;
//
//            $imagick->cropimage(
//                $newWidth,
//                $newHeight,
//                ($cropWidth - $newWidth) / 2,
//                ($cropHeight - $newHeight) / 2
//            );
//
//            $imagick->scaleimage(
//                $imagick->getImageWidth() * 4,
//                $imagick->getImageHeight() * 4
//            );
//        }
//
//
//        header("Content-Type: image/jpg");
//        echo $imagick->getImageBlob();
//    }
//
//    public function getThumb($type, $image, $size=100){
//        $path = config('app.storage').'/'.$type.'/'.$image;
//        $thumb = new \Imagick();
//        $thumb->readImage($path);
//        $thumb->resizeImage($size,$size, \Imagick::FILTER_LANCZOS, 1);
////        $thumb->writeImage('mythumb.gif');
////        $thumb->clear();
////        $thumb->destroy();
//
//        header("Content-Type: image/jpg");
//        echo $thumb->getImageBlob();
//    }
}
