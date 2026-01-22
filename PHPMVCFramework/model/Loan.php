<?php
namespace App\model;

use PDO;

class Loan {
    private $db;

    public function __construct() {
        $this->db = \App\core\Database::getInstance();
    }

    public function getAllLoans(){
        $sql = "
            SELECT 
                l.LoanID,
                b.Title,
                m.UserName,
                l.BorrowDate,
                l.DueDate,
                l.ReturnDate,
                l.Status
            FROM Loan l
            JOIN Member m ON l.MemberID = m.MemberID
            JOIN Book_Copy bc ON l.CopyID = bc.CopyID
            JOIN Book b ON bc.BookID = b.BookID
            ORDER BY l.BorrowDate DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAvailableCopy($book_id){
        $sql = "SELECT CopyID 
                FROM Book_Copy 
                WHERE BookID = ? AND Status = 'Available' 
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$book_id]);

        return $stmt->fetchColumn();
    }

    public function createLoan($member_id, $copy_id, $due_date){
        $sql = "INSERT INTO Loan (MemberID, CopyID, BorrowDate, DueDate)
                VALUES (?, ?, CURDATE(), ?)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$member_id, $copy_id, $due_date]);
    }

    public function markCopyBorrowed($copy_id){
        $sql = "UPDATE Book_Copy SET Status='Borrowed' WHERE CopyID=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$copy_id]);
    }

    public function markCopyReturned($copy_id){
        $sql = "UPDATE Book_Copy SET Status='Available' WHERE CopyID=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$copy_id]);
    }

    public function getCopyIdByLoan($loan_id){
        $sql = "SELECT CopyID FROM Loan WHERE LoanID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$loan_id]);
        return $stmt->fetchColumn();
    }

    public function updateLoanStatus($loan_id){
        $sql = "UPDATE Loan SET Status = 'Returned', ReturnDate = CURDATE() WHERE LoanID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$loan_id]);
    }

}
