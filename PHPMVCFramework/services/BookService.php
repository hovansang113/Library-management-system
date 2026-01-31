<?php

namespace App\services;

use App\model\Book;

class BookService
{
    protected Book $bookModel;

    public function __construct()
    {
        $this->bookModel = new Book();
    }

    public function create(array $data)
    {
        return $this->bookModel->createBook($data);
    }

    public function update(int $bookId, array $data)
    {
        return $this->bookModel->updateBook($bookId, $data);
    }
}
