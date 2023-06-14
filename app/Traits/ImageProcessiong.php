<?php
 
namespace App\Traits;
use Image;
use Storage;
use Illuminate\Support\Str; //sring to make a name
// use Intervention\Image\Facades\Image;


trait ImageProcessiong{
    public function get_mime($mime)
    {
        $extensions = [
            'image/jpeg' => '.jpg',
            'image/png' => '.png',
            'image/gif' => '.gif',
            'image/svg+xml' => '.svg',
            'image/tiff' => '.tiff',
            'image/webp' => '.webp',
        ];
        return $extensions[$mime] ?? null;
    }
    //save image
    public function saveImage($image){
        $img =Image::make($image);
        $extensions = $this->get_mime($img->mime());
        $str_random = str::random(8);
        $imagePath = $str_random.time().$extensions;
        $img->save(storage_path('app/imagesfb').'/'.$imagePath);
        return $imagePath;
    }
    // to make size
    public function aspect4resize($image , $width , $height){
        $img =Image::make($image);
        $extensions = $this->get_mime($img->mime());
        $str_random = str::random(8);
        // make a resize
        $img->resize($width , $height , function($constrain){
            $constrain->aspectRatio();
        });
        $imagePath = $str_random.time().$extensions;
        $img->save(storage_path('app/imagesfb').'/'.$imagePath);
        return $imagePath;
    }
    //to make height
    public function aspect4height($image , $width , $height){
        $img =Image::make($image);
        $extensions = $this->get_mime($img->mime());
        $str_random = str::random(8);
        // make a resize
        $img->resize(null , $height , function($constrain){
            $constrain->aspectRatio();
        });

        if($img->width()< $width){
            $img->resize($width , null);
        }
        else if($img->width() > $width){
            $img->crop($width , $height , 0 , 0);
        }
        $imagePath = $str_random.time().$extensions;
        $img->save(storage_path('app/imagesfb').'/'.$imagePath);
        return $imagePath;
    }
    public function saveImageAndThumbnail($Thefile , $thimb=false){
        $dataX = array();
        $dataX['image'] = $this->saveImage($Thefile);
        // Generate thumbnail if required
        if ($thimb) {
            $dataX['thumbnailsm'] = $this->aspect4resize($Thefile, 256, 144);
            $dataX['thumbnailmd'] = $this->aspect4resize($Thefile, 426, 240);
            $dataX['thumbnailxl'] = $this->aspect4resize($Thefile, 640, 360);

        }

        return $dataX;
    }

    public function deleteImage($filePath)
    {
        $imagePath = Storage::disk('imagesfp')->path($filePath);
    
        if (is_file($imagePath) && file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
}



