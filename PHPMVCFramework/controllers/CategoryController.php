<?php
namespace App\controllers;

use App\core\Controller;
use App\core\Request;
use App\model\CategoryModel;

class CategoryController extends Controller
{
    
    public function showCategories()
    {
        $model = new CategoryModel();
        $categories = $model->getAllCategories();

        $this->setLayout('admin/mainAdmin');
        return $this->render('admin/bookInventory', [
            'categories' => $categories
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
                // Flash message - xóa thành công
                $_SESSION['success'] = 'Danh mục đã được xóa thành công!';
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
}
