<?php

namespace App\model;
use PDO;

class UserManagementModel {
    private $db;

    public function __construct() {
        $this->db = \App\core\Database::getInstance();
    }

    public function getAllUsers() {
        $sql = "SELECT * FROM Member 
                WHERE Role = 'User' 
                ORDER BY MemberID";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUser($data) {
        $sql = "INSERT INTO Member 
                (UserName, Email, Phone, Password, Role, Status, RegisterDate)
                VALUES 
                (:UserName, :Email, :Phone, :Password, 'User', 'Active', NOW())";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':UserName', $data['UserName']);
        $stmt->bindValue(':Email', $data['Email']);
        $stmt->bindValue(':Phone', $data['Phone']);

        $hashedPassword = password_hash($data['Password'], PASSWORD_BCRYPT);
        $stmt->bindValue(':Password', $hashedPassword);

        return $stmt->execute();
    }

    public function blockUser($memberId) {
    $sql = "UPDATE Member SET Status = 'Blocked' WHERE MemberID = :MemberID AND Role = 'User'";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':MemberID', $memberId);
    return $stmt->execute();
    }

    public function unblockUser($memberId) {
        $sql = "UPDATE Member SET Status = 'Active' WHERE MemberID = :MemberID AND Role = 'User'";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':MemberID', $memberId);
        return $stmt->execute();
    }

    public function getUserByEmail($email) {
        $sql = "SELECT * FROM Member WHERE Email = :Email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':Email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
