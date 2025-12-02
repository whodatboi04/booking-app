<?php

namespace App\Services\Api;


class UploadFileService
{

    public function uploadImage($file, $fileLocation): string
    {
        $fileRenamed = now()->format('Y-m-d') . '-' . $file->hashName();
        $path = $file->storeAs($fileLocation, $fileRenamed);
        if (! $path) {
            throw new \Exception('Error uploading file');
        }

        return $fileRenamed;
    }
}
