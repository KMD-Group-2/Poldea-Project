<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Image;

trait FileHandler
{

    public function uploadFilePath($file, $directory, $nullable = false)
    {
        if ($file) {
            $image_type = config('app.image_type');
            $upload_path = public_path() . "/upload/{$directory}/";
            if (!file_exists($upload_path)) {
                File::makeDirectory($upload_path, $mode = 0777, true, true);
            }
            $file_ext = $file->getClientOriginalExtension();
            $filename = time() .  round(microtime(true) * 1000) . '.' . $file_ext;

            if (in_array($file_ext, $image_type)) {
                // Image File
                $imgFile = Image::make($file->getRealPath());
                $imgFile->resize(500, 400, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($upload_path . '/' . $filename);
            } else {
                $file->move($upload_path, $filename);
            }

            $file_url = "/upload/{$directory}/" . $filename;
            return $file_url;
        }
        return null;
    }

    public function deleteFilePath($path)
    {
        if ($path) {
            try {
                File::delete($path);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    }
}
