<?php

namespace App\model;

use PDO;

class Book_request
{
    private $db;

    public function __construct()
    {
        $this->db = \App\core\Database::getInstance();
    }

    public function create(array $data)
    {
        $sql = "INSERT INTO book_request (MemberID, Title, Author, Reason) VALUES (:MemberID, :Title, :Author, :Reason)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':MemberID' => $data['MemberID'],
            ':Title'    => $data['Title'],
            ':Author'   => $data['Author'],
            ':Reason'   => $data['Reason']
        ]);
    }

    public function getRequestsByUserId(int $userId)
    {
        $sql = "SELECT * FROM book_request WHERE MemberID = :userId ORDER BY RequestDate DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllRequestsWithUserDetails()
    {
        $sql = "SELECT 
                    br.RequestID,
                    br.RequestDate,
                    m.UserName AS MemberName,
                    br.Title,
                    br.Author,
                    br.Reason,
                    br.Status
                FROM book_request br
                JOIN Member m ON br.MemberID = m.MemberID
                ORDER BY br.RequestDate DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus(int $requestId, string $status)
    {
        if (!in_array($status, ['Approved', 'Rejected'])) {
            return false;
        }
        $sql = "UPDATE book_request SET Status = :status WHERE RequestID = :requestId";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':status'    => $status,
            ':requestId' => $requestId
        ]);
    }

    public function getRequestStats()
    {
        $sql = "SELECT
                    COUNT(*) AS total,
                    SUM(CASE WHEN Status = 'Pending' THEN 1 ELSE 0 END) AS pending,
                    SUM(CASE WHEN Status = 'Approved' THEN 1 ELSE 0 END) AS approved,
                    SUM(CASE WHEN Status = 'Rejected' THEN 1 ELSE 0 END) AS rejected
                FROM book_request";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: ['total' => 0, 'pending' => 0, 'approved' => 0, 'rejected' => 0];
    }
}