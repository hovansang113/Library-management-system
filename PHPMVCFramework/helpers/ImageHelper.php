<?php

namespace App\helpers;

class ImageHelper
{
    public function uploadBookImage($file, $bookId = null)
    {
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($fileExt, $allowedExtensions)) {
            throw new \Exception('Chỉ cho phép upload ảnh (jpg, jpeg, png, gif)!');
        }

        $uploadDir = __DIR__ . '/../public/img/homepage/item/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileName = $bookId
            ? 'book_' . $bookId . '.' . $fileExt
            : 'book_' . time() . '_' . rand(1000, 9999) . '.' . $fileExt;

        $uploadPath = $uploadDir . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            throw new \Exception('Lỗi khi upload ảnh!');
        }

        return '/img/homepage/item/' . $fileName;
    }
}