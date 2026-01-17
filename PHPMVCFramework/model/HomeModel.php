<?php
namespace App\model;
use PDO;
class HomeModel {
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
}