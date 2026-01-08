<?php
// the purpore of this class is mange status of class
namespace App\core;
class Response{
    public function setStatusCode(int $code){
        http_response_code($code);
    }
}