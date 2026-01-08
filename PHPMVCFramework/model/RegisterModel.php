<?php
namespace App\model;
use App\core\Model;

class RegisterModel extends Model{
    public String $firstname;
    public String $lastName;
    public String $email;
    public String $password;
    public String $passwordConfirm;

    public function register(){
        echo 'Creating new ';
    }

    public function rules(): array{
        return [
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_MIN, min => 8], [self::RULE_MAX, max => 24]],
            'password' => [self::RULE_REQUIRED],
            'comfirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password'] ],
        ];
    }
}