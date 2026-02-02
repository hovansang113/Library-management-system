<?php
namespace App\model;
use PDO;

class Category {
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
            // Kiểm tra xem có sách nào trong danh mục này đang được mượn không
            $sqlCheckLoan = "
                SELECT 1 FROM Loan l
                JOIN Book_Copy bc ON l.CopyID = bc.CopyID
                JOIN Book b ON bc.BookID = b.BookID
                WHERE b.CategoryID = :id AND l.Status = 'Borrowed'
                LIMIT 1
            ";
            $stmtCheck = $this->db->prepare($sqlCheckLoan);
            $stmtCheck->bindValue(':id', $id, PDO::PARAM_INT);
            $stmtCheck->execute();

            if ($stmtCheck->fetch()) {
                // Nếu có sách đang được mượn, không cho xóa và báo lỗi
                throw new \Exception('Không thể xóa danh mục vì có sách thuộc danh mục này đang được mượn.');
            }

            // Nếu không, tiến hành xóa trong một transaction
            $this->db->beginTransaction();
            
            // Xóa các sách thuộc danh mục này. Thao tác này sẽ tự động xóa các bản sao (Book_Copy)
            // nhờ có 'ON DELETE CASCADE' trong bảng Book_Copy.
            $sqlDeleteBooks = "DELETE FROM Book WHERE CategoryID = :id";
            $stmtDeleteBooks = $this->db->prepare($sqlDeleteBooks);
            $stmtDeleteBooks->bindValue(':id', $id, PDO::PARAM_INT);
            $stmtDeleteBooks->execute();
            
            // Cuối cùng, xóa danh mục
            $sqlDeleteCategory = "DELETE FROM Category WHERE CategoryID = :id";
            $stmtDeleteCategory = $this->db->prepare($sqlDeleteCategory);
            $stmtDeleteCategory->bindValue(':id', $id, PDO::PARAM_INT);
            $result = $stmtDeleteCategory->execute();
            
            $this->db->commit();
            
            return $result;
        } catch (\Exception $e) { // Bắt cả PDOException và Exception tự định nghĩa
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            throw $e; // Ném lại exception để controller xử lý
        }
    }

     public function getCategoryStats() {
        $sql = "
            SELECT 
                c.CategoryName,
                SUM(b.Quantity) AS total_books
            FROM Category c
            LEFT JOIN Book b ON c.CategoryID = b.CategoryID
            GROUP BY c.CategoryID
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
  
}
