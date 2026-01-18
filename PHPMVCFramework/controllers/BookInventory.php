<?php
namespace App\controllers;

use App\core\Controller;
use App\core\Request;
use App\model\CategoryModel;

class BookInventory extends Controller
{
    
    public function showCategories()
    {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategories();

        // Lấy cả books
        $bookModel = new \App\model\BookModel();
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
                    $model = new CategoryModel();
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

                $model = new CategoryModel();
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
                    $model = new CategoryModel();
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
        if($request->isPost()) {
            $data = $request->getBody();
            
            // Xử lý upload file ảnh
            if (isset($_FILES['Image']) && $_FILES['Image']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['Image'];
                $fileName = $file['name'];
                $fileTmpName = $file['tmp_name'];
                $fileSize = $file['size'];
                $fileType = $file['type'];

                
                $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
                
                
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array(strtolower($fileExt), $allowedExtensions)) {
                    $_SESSION['error'] = 'Chỉ cho phép upload ảnh (jpg, jpeg, png, gif)!';
                    header('Location: /admin/bookInventory');
                    exit;
                }
                
                
                $uploadDir = __DIR__ . '/../public/img/homepage/item/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
      
                $newFileName = 'book_' . time() . '_' . rand(1000, 9999) . '.' . $fileExt;
                $uploadPath = $uploadDir . $newFileName;
                
                
                if (move_uploaded_file($fileTmpName, $uploadPath)) {
                  
                    $data['Image'] = '/img/homepage/item/' . $newFileName;
                    $bookModel = new \App\model\BookModel();
                    $bookModel->createBook($data);
                    $_SESSION['success'] = 'Sách đã được thêm thành công!';
                } else {
                    $_SESSION['error'] = 'Lỗi khi upload ảnh!';
                }
            } else {
                $_SESSION['error'] = 'Vui lòng chọn ảnh!';
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
                $model = new \App\model\BookModel();
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
        if($request->isPost()) {
            $data = $request->getBody();
            $bookId = $data['BookID'] ?? null;

            if (!$bookId) {
                $_SESSION['error'] = 'ID sách không hợp lệ!';
                header('Location: /admin/bookInventory');
                exit;
            }

            $bookModel = new \App\model\BookModel();

            // Xử lý upload file ảnh nếu có
            if (isset($_FILES['Image']) && $_FILES['Image']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['Image'];
                $fileName = $file['name'];
                $fileTmpName = $file['tmp_name'];
                $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
                
                // Kiểm tra định dạng file
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array(strtolower($fileExt), $allowedExtensions)) {
                    $_SESSION['error'] = 'Chỉ cho phép upload ảnh (jpg, jpeg, png, gif)!';
                    header('Location: /admin/bookInventory');
                    exit;
                }
                
                // Tạo thư mục nếu chưa tồn tại
                $uploadDir = __DIR__ . '/../public/img/homepage/item/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                // Tạo tên file mới theo BookID
                $newFileName = 'book' . $bookId . '.' . $fileExt;
                $uploadPath = $uploadDir . $newFileName;
                
                // Di chuyển file
                if (move_uploaded_file($fileTmpName, $uploadPath)) {
                    $data['Image'] = '/img/homepage/item/' . $newFileName;
                } else {
                    $_SESSION['error'] = 'Lỗi khi upload ảnh!';
                    header('Location: /admin/bookInventory');
                    exit;
                }
            }
            
            try {
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

        $bookModel = new \App\model\BookModel();
        $books = $bookModel->searchBooks($keyword);

        header('Content-Type: application/json');
        return json_encode(['books' => $books]);
    }

}


