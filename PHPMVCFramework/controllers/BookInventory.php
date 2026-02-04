<?php

namespace App\controllers;

use App\core\Controller;
use App\core\Request;
use App\model\Category;
use App\helpers\ImageHelper;
use App\services\ImportExcel;

class BookInventory extends Controller
{

    public function showCategories()
    {
        $categoryModel = new Category();
        $categories = $categoryModel->getAllCategories();


        $bookModel = new \App\model\Book();
        $books = $bookModel->getAllBooks();

        $this->setLayout('admin/mainAdmin');
        return $this->render('admin/BookInventory', [
            'categories' => $categories,
            'books' => $books
        ]);
    }

    public function addCategory(Request $request)
    {
        if ($request->isPost()) {
            $data = $request->getBody();
            $categoryName = $data['CategoryName'] ?? '';

            try {
                if (!empty($categoryName)) {
                    $model = new Category();
                    $model->createCategory($categoryName);
                    $_SESSION['success'] = 'Danh mục đã được tạo thành công!';
                } else {
                    $_SESSION['error'] = 'Vui lòng nhập tên danh mục!';
                }
            } catch (\Exception $e) {
                $_SESSION['error'] = $e->getMessage();
            }

            header('Location: /admin/bookInventory');
            exit;
        }


        return $this->showCategories();
    }


    public function deleteCategory(Request $request)
    {
        $id = $request->getBody()['id'] ?? null;

        if ($id) {
            try {

                $model = new Category();
                $model->deleteCategory($id);
            } catch (\PDOException $e) {
                // Flash message - lỗi
                $_SESSION['error'] = 'Lỗi khi xóa danh mục: ' . $e->getMessage();
            }
        }
        header('Location: /admin/bookInventory');
        exit;
    }


    public function updateCategory(Request $request)
    {
        if ($request->isPost()) {
            $data = $request->getBody();
            $id = $data['id'] ?? null;
            $name = $data['CategoryName'] ?? '';

            try {
                if (!empty($id) && !empty($name)) {
                    $model = new Category();
                    $model->updateCategory($id, $name);
                    $_SESSION['success'] = 'Danh mục đã được cập nhật thành công!';
                } else {
                    $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin!';
                }
            } catch (\Exception $e) {
                $_SESSION['error'] = $e->getMessage();
            }
        }

        header('Location: /admin/bookInventory');
        exit;
    }


    public function addBook(Request $request)
    {
        if ($request->isPost()) {
            $data = $request->getBody();

            try {
                $imageHelper = new ImageHelper();
                $data['Image'] = $imageHelper->uploadBookImage(
                    $_FILES['Image'] ?? null
                ) ?? '/img/homepage/item/default-book.png';

                $bookModel = new \App\model\Book();
                $bookModel->createBook($data);
                $_SESSION['success'] = 'Sách đã được thêm thành công!';
            } catch (\Exception $e) {
                $_SESSION['error'] = $e->getMessage();
            }

            header('Location: /admin/bookInventory');
            exit;
        }
    }


    public function deleteBook(Request $request)
    {
        $id = $request->getBody()['id'] ?? null;

        if ($id) {
            try {
                $model = new \App\model\Book();
                $result = $model->deleteBook($id);

                if (!$result['success']) {
                    $_SESSION['error'] = $result['message'];
                } else {
                    $_SESSION['success'] = $result['message'];
                }
            } catch (\PDOException $e) {
                $_SESSION['error'] = 'Lỗi khi xóa sách: ' . $e->getMessage();
            }
        }

        header('Location: /admin/bookInventory');
        exit;
    }

    public function updateBook(Request $request)
    {
        if ($request->isPost()) {
            $data = $request->getBody();
            $bookId = $data['BookID'] ?? null;

            if (!$bookId) {
                $_SESSION['error'] = 'ID sách không hợp lệ!';
                header('Location: /admin/bookInventory');
                exit;
            }

            $bookModel = new \App\model\Book();

            $currentBook = $bookModel->getBookById($bookId);
            if (!$currentBook) {
                $_SESSION['error'] = 'Sách không tồn tại!';
                header('Location: /admin/bookInventory');
                exit;
            }

            try {
                $imageHelper = new ImageHelper();
                $newImage = $imageHelper->uploadBookImage($_FILES['Image'] ?? null, $bookId);

                $data['Image'] = $newImage ?: $currentBook['Image'];

                $bookModel->updateBook($bookId, $data);
                $_SESSION['success'] = 'Sách đã được cập nhật thành công!';
            } catch (\Exception $e) {
                $_SESSION['error'] = 'Lỗi khi cập nhật sách: ' . $e->getMessage();
            }
        }

        header('Location: /admin/bookInventory');
        exit;
    }

    public function searchBooks(Request $request)
    {
        $keyword = $request->getBody()['keyword'] ?? '';

        if (empty($keyword)) {
            return json_encode(['books' => []]);
        }

        $bookModel = new \App\model\Book();
        $books = $bookModel->searchBooks($keyword);

        header('Content-Type: application/json');
        return json_encode(['books' => $books]);
    }

    public function importExcel(Request $request)
    {
        if (!$request->isPost()) return;

        try {
            $file = $_FILES['excel'] ?? null;
            if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
                throw new \Exception('Vui lòng chọn file Excel hợp lệ!');
            }

            $tmpPath = $file['tmp_name'];

            $importService = new ImportExcel();
            $total = $importService->importBooks($tmpPath);

            $_SESSION['success'] = "Import thành công $total sách";
        } catch (\Throwable $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: /admin/bookInventory');
        exit;
    }
}
