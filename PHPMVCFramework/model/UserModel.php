<?php
namespace App\model;

class UserModel {
    
    private $db;
    
    public function __construct() {
        $this->db = \App\core\Database::getInstance();
    }
    
    /**
     * Xác thực user với email và password
     * @param string $email
     * @param string $password
     * @return array|false Trả về user info nếu đúng, false nếu sai
     */
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
    
    /**
     * Lấy user theo ID
     * @param int $id
     * @return array|false
     */
    public function getUserById(int $id) {
        $sql = "SELECT * FROM Member WHERE MemberID = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Cập nhật thông tin user
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateUser(int $id, array $data) {
        $sql = "UPDATE Member SET 
                UserName = :username, 
                Phone = :phone 
                WHERE MemberID = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':username' => $data['UserName'],
            ':phone' => $data['Phone'],
            ':id' => $id
        ]);
    }
}