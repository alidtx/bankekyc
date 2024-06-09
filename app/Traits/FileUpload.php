<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait FileUpload
{
    public function saveFile($destinationFolder, $file, $fileNamePersonal)
    {
        $destinationPath = "upload/" . $destinationFolder . "/";
        Log::info("destinationPath: " . $destinationPath);
        if (!is_dir(public_path($destinationPath)))
            mkdir(public_path($destinationPath), 0777, true);
        //        rename('image1.jpg', 'del/image1.jpg');
        //        move_uploaded_file ( string $filename , string $destination )
        $file->move(public_path($destinationPath), $fileNamePersonal);
        return $destinationPath . $fileNamePersonal;
    }
}
