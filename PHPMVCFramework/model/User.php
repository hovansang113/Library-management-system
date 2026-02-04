<?php

namespace App\model;
use PDO;

class User {
    private $db;

    public function __construct() {
        $this->db = \App\core\Database::getInstance();
    }
    public function verifyUser(string $email, string $password) {
        try {
            $sql = "SELECT * FROM Member WHERE Email = :email"; 
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':email' => $email]);
            
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if (!$user || !password_verify($password, $user['Password'])) {
                return false;
            }
            
            if (isset($user['Status']) && $user['Status'] !== 'Active') {
                return false; 
            }
            
            
            return $user;
            
        } catch (\PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            return false;
        }
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

    public function countUsers(){
        $sql = "SELECT COUNT(*) AS total FROM Member WHERE Role = 'User'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getUserById($memberId) {
        $sql = "SELECT * FROM Member WHERE MemberID = :MemberID LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':MemberID', $memberId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePassword($memberId, $newPassword)
    {
        $sql = "UPDATE Member SET Password = :password WHERE MemberID = :memberId";
        $stmt = $this->db->prepare($sql);

        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        $stmt->bindValue(':password', $hashedPassword);
        $stmt->bindValue(':memberId', $memberId, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function verifyCurrentPassword($memberId, $currentPassword)
    {
        $user = $this->getUserById($memberId);
        if (!$user) {
            return false;
        }
        return password_verify($currentPassword, $user['Password']);
    }
}

