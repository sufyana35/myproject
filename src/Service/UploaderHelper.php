<?php

namespace App\Service;

use App\Entity\Upload;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploaderHelper
{

    /**
     * @param UploadedFile $uploadedFile
     * @param string $destination
     *
     * @return Upload
     */
    public function uploadFile(UploadedFile $uploadedFile, string $destination): Upload
    {
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = $originalFilename.''.'.'.$uploadedFile->guessClientExtension();
        $uploadedFile->move(
            $destination,
            $newFilename
        );

        return new Upload($newFilename);
    }
}
