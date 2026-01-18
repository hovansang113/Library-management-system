<?php
namespace App\model;
use PDO;

class CategoryModel {
    private $db;

    function __construct() {
        $this->db = \App\core\Database::getInstance();
    }

    public function createCategory($CategoryName){
        try {
            if (empty(trim($CategoryName))) {
                throw new \Exception('Tên danh mục không được để trống');
            }
            
            $sql = "INSERT INTO Category(CategoryName) VALUES (:CategoryName)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':CategoryName', trim($CategoryName), PDO::PARAM_STR);
            return $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception('Lỗi khi tạo danh mục: ' . $e->getMessage());
        }
    }

    public function getAllCategories(){
        $sql = "SELECT * FROM Category";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateCategory($id, $name){
        try {
            if (empty($id) || empty(trim($name))) {
                throw new \Exception('ID danh mục và tên danh mục không được để trống');
            }
            
            $sql = "UPDATE Category SET CategoryName = :name WHERE CategoryID = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':name', trim($name), PDO::PARAM_STR);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception('Lỗi khi cập nhật danh mục: ' . $e->getMessage());
        }
    }

    public function deleteCategory($id){
        try {
            
            $this->db->beginTransaction();
            
           
            $sqlDeleteBooks = "DELETE FROM Book WHERE CategoryID = :id";
            $stmtDeleteBooks = $this->db->prepare($sqlDeleteBooks);
            $stmtDeleteBooks->bindValue(':id', $id, PDO::PARAM_INT);
            $stmtDeleteBooks->execute();
            
            
            $sqlDeleteCategory = "DELETE FROM Category WHERE CategoryID = :id";
            $stmtDeleteCategory = $this->db->prepare($sqlDeleteCategory);
            $stmtDeleteCategory->bindValue(':id', $id, PDO::PARAM_INT);
            $result = $stmtDeleteCategory->execute();
            
            
            $this->db->commit();
            
            return $result;
        } catch (\PDOException $e) {
            
            $this->db->rollBack();
            throw $e;
        }
    }
}
