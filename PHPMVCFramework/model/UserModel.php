<?php
namespace App\model;
// Bỏ "extends Database" ở đây
class UserModel {
    public function verifyUser(String $email, String $password) {
        $db = \App\core\Database::getInstance();
        
        $sql = "SELECT * FROM Member WHERE Email = :email"; 
        $stmt = $db->prepare($sql);
        $stmt->execute([':email' => $email]);
        
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($user && isset($user['Password'])) {
            if (password_verify($password, $user['Password'])) {
                return $user;
            }
        }
        return false;
    }
}
