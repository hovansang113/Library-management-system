<?php
namespace App\model;

use PDO;
 
class Book_request {
    private $db;
    private $table = 'Book_request';

    public function __construct() {
        $this->db = \App\core\Database::getInstance();
    }

    public function create(array $data) {
        try {

            $stmt = $this->db->prepare(
                "INSERT INTO {$this->table} (MemberID, Title, Author, Reason) 
                 VALUES (:MemberID, :Title, :Author, :Reason)"
            );
            $stmt->bindParam(':MemberID', $data['MemberID']);
            $stmt->bindParam(':Title', $data['Title']);
            $stmt->bindParam(':Author', $data['Author']);
            $stmt->bindParam(':Reason', $data['Reason']);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("BookRequest creation error: " . $e->getMessage());
            return false;
        }
    }

    public function getRequestsByUserId(int $userId) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE MemberID = :MemberID ORDER BY RequestDate DESC");
            $stmt->bindParam(':MemberID', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("getRequestsByUserId error: " . $e->getMessage());
            return [];
        }
    }

    public function getAllRequests() {
        try {
            $stmt = $this->db->prepare(
                "SELECT br.*, m.UserName 
                 FROM {$this->table} AS br
                 JOIN Member AS m ON br.MemberID = m.MemberID
                 ORDER BY br.RequestDate DESC"
            );
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("getAllRequests error: " . $e->getMessage());
            return [];
        }
    }

    public function updateStatus(int $requestId, string $status) {
        // Kiểm tra để đảm bảo status là một trong các giá trị hợp lệ
        if (!in_array($status, ['Approved', 'Rejected', 'Pending'])) {
            return false;
        }
        try {
            $stmt = $this->db->prepare(
                "UPDATE {$this->table} SET Status = :Status WHERE RequestID = :RequestID"
            );
            $stmt->bindParam(':Status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':RequestID', $requestId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("updateStatus error: " . $e->getMessage());
            return false;
        }
    }
}
