<?php
namespace App\model;

use PDO;

class Home {
    private $db;

    public function __construct() {
        $this->db = \App\core\Database::getInstance();
    }

    // Total Members
    public function countMembers() {
        $sql = "SELECT COUNT(*) FROM Member WHERE Role = 'User'";
        return $this->db->query($sql)->fetchColumn();
    }

    // Total Books (tổng bản copy)
    public function countBooks() {
        $sql = "SELECT COUNT(*) FROM Book_Copy";
        return $this->db->query($sql)->fetchColumn();
    }

    // Borrowed books
    public function countBorrowed() {
        $sql = "SELECT COUNT(*) FROM Book_Copy WHERE Status = 'Borrowed'";
        return $this->db->query($sql)->fetchColumn();
    }

    // Available books
    public function countAvailable() {
        $sql = "SELECT COUNT(*) FROM Book_Copy WHERE Status = 'Available'";
        return $this->db->query($sql)->fetchColumn();
    }

    // Recent Borrowings
    public function getRecentBorrowings($limit = 5) {
        $sql = "
            SELECT 
                b.Title AS title,
                m.UserName AS borrower,
                l.BorrowDate AS borrowed_date,
                l.DueDate AS due_date,
                l.Status AS status
            FROM Loan l
            JOIN Book_Copy bc ON l.CopyID = bc.CopyID
            JOIN Book b ON bc.BookID = b.BookID
            JOIN Member m ON l.MemberID = m.MemberID
            ORDER BY l.BorrowDate DESC
            LIMIT :limit
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
