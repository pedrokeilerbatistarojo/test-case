<?php

namespace App\Services\Users;

use CodeIgniter\HTTP\IncomingRequest;

class UploadUserPictureService
{
    /**
     * Upload file picture
     * @param IncomingRequest $request
     * @return string|null
     */
    public static function handle(IncomingRequest $request): ?string
    {
        $img = $request->getFile('picture');

        if (! $img->isValid()) {
            throw new \RuntimeException($img->getErrorString() . '(' . $img->getError() . ')');
        }

        if (! $img->hasMoved()) {
            return WRITEPATH . 'uploads/' . $img->store();
        }

        return null;
    }

    /**
     * Convert Picture base64 encoded
     * @param array $data
     * @return string|null
     */
    public static function handleBase64(array $data): ?string
    {
        if (!isset($data['picture'])){
            return null;
        }
        $imageBase64 = $data['picture'];

        // Decode picture to base64
        $imageData = base64_decode($imageBase64);

        $uploadPath = WRITEPATH . 'uploads/';
        $filename = uniqid('image_') . '.jpg';
        $filePath = $uploadPath . $filename;

        file_put_contents($filePath, $imageData);

        return $filePath;
    }
}