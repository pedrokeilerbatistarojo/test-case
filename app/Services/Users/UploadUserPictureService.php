<?php

namespace App\Services\Users;

use CodeIgniter\HTTP\IncomingRequest;
use RuntimeException;

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

        if (!$img->isValid()) {
            throw new RuntimeException($img->getErrorString() . '(' . $img->getError() . ')');
        }

        if (!$img->hasMoved()) {
            return self::storeImage($img->store());
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
        if (!isset($data['picture'])) {
            return null;
        }

        // Decode picture to base64
        $imageData = base64_decode($data['picture']);

        $filename = uniqid('image_') . '.jpg';

        return self::storeImage($filename, $imageData);
    }

    /**
     * Store the image in the specified directory
     *
     * @param string $filename
     * @param string|null $imageData
     * @return string
     */
    protected static function storeImage(string $filename, ?string $imageData = null): string
    {
        $uploadPath = WRITEPATH . 'uploads/';
        $filePath = $uploadPath . $filename;

        if ($imageData !== null) {
            file_put_contents($filePath, $imageData);
        }

        return $filePath;
    }
}