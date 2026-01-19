<?php
namespace App\model;

use PDO;

class Book {
    private $db;

    public function __construct() {
        $this->db = \App\core\Database::getInstance();
    }

    public function getLatestBooks($limit = 4){
        $sql = "SELECT 
                    b.BookID, b.Title, b.Author, b.Image, c.CategoryName as Category, b.Quantity,
                    bc.Status,
                    SUM(CASE WHEN bc.Status = 'Available' THEN 1 ELSE 0 END) as AvailableCopies
                FROM Book b
                INNER JOIN Category c on b.CategoryID = c.CategoryID
                LEFT JOIN Book_Copy bc on b.BookID = bc.BookID
                GROUP BY b.BookID, b.Title, b.Author, b.Image, c.CategoryName, b.Quantity
                ORDER BY b.BookID DESC
                LIMIT :limit 
         ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

     public function getAllBooks() {
     $sql = "SELECT 
                    b.BookID, b.Title, b.Author, b.Image, b.Description, c.CategoryName as Category, b.Quantity,
                    bc.Status,
                    SUM(CASE WHEN bc.Status = 'Available' THEN 1 ELSE 0 END) as AvailableCopies
                FROM Book b
                INNER JOIN Category c on b.CategoryID = c.CategoryID
                LEFT JOIN Book_Copy bc on b.BookID = bc.BookID
                GROUP BY b.BookID, b.Title, b.Author, b.Image, c.CategoryName, b.Quantity
                ORDER BY b.BookID DESC
                
         ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchBooks($keyword) {
        $sql = "
            SELECT 
                b.BookID,
                b.Title,
                b.Author,
                b.Image,
                c.CategoryName AS Category,
                b.Quantity,
                SUM(CASE WHEN bc.Status = 'Available' THEN 1 ELSE 0 END) AS AvailableCopies
            FROM Book b
            JOIN Category c ON b.CategoryID = c.CategoryID
            LEFT JOIN Book_Copy bc ON b.BookID = bc.BookID
            WHERE b.Title LIKE :keyword 
            GROUP BY b.BookID, b.Title, b.Author, b.Image, c.CategoryName, b.Quantity
            ORDER BY b.BookID DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':keyword' => '%' . $keyword . '%'
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function createBook($data) {
        $sql = "
            INSERT INTO Book (CategoryID, Title, Author, Image, Description, Quantity)
            VALUES (:categoryId, :title, :author, :image, :description, :quantity)
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':categoryId' => $data['CategoryID'],
            ':title' => $data['Title'],
            ':author' => $data['Author'],
            ':image' => $data['Image'],
            ':description' => $data['Description'],
            ':quantity' => $data['Quantity']
        ]);
    }

    public function updateBook($id, $data) {
        $sql = "
            UPDATE Book 
            SET CategoryID = :categoryId,
                Title = :title,
                Author = :author,
                Image = :image,
                Description = :description,
                Quantity = :quantity
            WHERE BookID = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':categoryId' => $data['CategoryID'],
            ':title' => $data['Title'],
            ':author' => $data['Author'],
            ':image' => $data['Image'],
            ':description' => $data['Description'],
            ':quantity' => $data['Quantity'],
            ':id' => $id
        ]);
    }

    public function deleteBook($id) {
        $check = $this->db->prepare("
            SELECT COUNT(*) 
            FROM Loan l
            JOIN Book_Copy bc ON l.CopyID = bc.CopyID
            WHERE bc.BookID = :id
              AND l.Status = 'Borrowed'
        ");

        $check->execute([':id' => $id]);

        if ($check->fetchColumn() > 0) {
            return [
                'success' => false,
                'message' => 'Không thể xóa sách vì đang có người mượn.'
            ];
        }

   
        $stmt = $this->db->prepare("DELETE FROM Book WHERE BookID = :id");

        if ($stmt->execute([':id' => $id])) {
            return [
                'success' => true,
                'message' => 'Xóa sách thành công.'
            ];
        }

        return [
            'success' => false,
            'message' => 'Xóa sách thất bại.'
        ];
    }


}
