<?php
namespace App\model;

use PDO;

class BookCopy {
    private $db;

    public function __construct() {
        $this->db = \App\core\Database::getInstance();
    }

    public function countBorrowedCopies(){
        $sql = "SELECT COUNT(*) AS total_borrowed FROM Book_Copy WHERE Status = 'Borrowed'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_borrowed'];
    }
    public function countAvailableCopies(){
        $sql = "SELECT COUNT(*) AS total_available FROM Book_Copy WHERE Status = 'Available'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_available'];
    }
    

}