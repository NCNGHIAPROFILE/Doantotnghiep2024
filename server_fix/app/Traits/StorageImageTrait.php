<?php
namespace App\Traits;

use App\Common\ImageUser;

trait StorageImageTrait {
    public function deleteImage($path)
    {
        $file = public_path(ImageUser::LINKDELETEIMAGE) . $path;
            if (file_exists($file)) {
                @unlink($file);
            }
    }
    public function createImage($file , $path)
    {
        $file->store('avatar', 'public');
        return $file->hashName();
    }
}