<?php

namespace App\services;

use App\services\BookService;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportExcel
{
    protected BookService $bookService;

    public function __construct()
    {
        $this->bookService = new BookService();
    }

    public function importBooks(string $filePath): int
    {
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        unset($rows[0]);

        $count = 0;

        foreach ($rows as $row) {

            if (empty($row[0])) {
                continue;
            }

            $imageName = trim($row[5] ?? '');

            $imagePath = '/img/book/default-book.png';

            if ($imageName) {
                $fullPath = $_SERVER['DOCUMENT_ROOT'] . '/img/book/' . $imageName;
                if (file_exists($fullPath)) {
                    $imagePath = '/img/book/' . $imageName;
                }
            }

            $data = [
                'Title'       => trim($row[0]),
                'Author'      => trim($row[1]),
                'CategoryID'  => (int) $row[2],
                'Description' => $row[3] ?? null,
                'Quantity'    => (int) $row[4],
                'Image'       => $imagePath
            ];

            $this->bookService->create($data);
            $count++;
        }

        return $count;
    }
}
