<?php
namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadImageTrait {
    private static function moveFileToPublic(UploadedFile $file, $path) {
        $fileName = time() .'-'. rand(1000,100000) .  '.' . $file->getClientOriginalExtension();
        Storage::disk('oss')->put($path ."/". $fileName, $file->get());
        return "$path/$fileName";
    }

    private static function moveFileToLocalDisk(UploadedFile $file, $path) {
        $fileName = time() .'-'. rand(1000,100000) .  '.' . $file->getClientOriginalExtension();
        Storage::disk('oss')->put($path ."/". $fileName, $file->get());
        return "$path/$fileName";
    }

    private static function storeContentToLocalDisk(string $fileContent, string $fileExtension, $path): string
    {
        $fileName = time() .'-'. rand(1000,100000) .  '.' . $fileExtension;
        Storage::disk('oss')->put($path ."/". $fileName, $fileContent);
        return "$path/$fileName";
    }
}
