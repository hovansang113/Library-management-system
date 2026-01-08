<?php

namespace App\core;

class Request
{
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        
        // Cắt bỏ query string (?id=1&name=abc)
        $position = strpos($path, '?');
        if ($position !== false) {
            $path = substr($path, 0, $position);
        }

        // Lấy base path từ SCRIPT_NAME
        // Ví dụ: /PHPMVCFramework/public/index.php
        $scriptName = $_SERVER['SCRIPT_NAME']; // /public/index.php
        $scriptDir  = dirname($scriptName);    // /public

        // Nếu có base folder (ví dụ /myproject/public), loại bỏ nó khỏi path
        if ($scriptDir !== '/' && strpos($path, $scriptDir) === 0) {
            $path = substr($path, strlen($scriptDir));
        }

        // Đảm bảo path luôn bắt đầu bằng / và không rỗng
        $path = $path === '' || $path === false ? '/' : '/' . ltrim($path, '/');

        return $path;
    }

    public function method()
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    public function isGet(){
        return $this->method() === 'GET';
    }

    public function isPost(){
        return $this->method() === 'POST';
    }
    public function isPut(){
        return $this->method() === 'PUT';
    }
    public function isDelete(){
        return $this->method() === 'DELETE';
    }


    public function getBody(){
        $body = [];
        if (strtolower($this->method()) === 'post') {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if (strtolower($this->method()) === 'get') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if (strtolower($this->method()) === 'put') {
            parse_str(file_get_contents("php://input"), $putVars);
            foreach ($putVars as $key => $value) {
                $body[$key] = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if (strtolower($this->method()) === 'delete') {
            foreach ($_SERVER as $key => $value) {
                $body[$key] = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $body;
    }

}