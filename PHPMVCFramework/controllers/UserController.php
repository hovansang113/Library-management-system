<?php
namespace App\controllers;

use App\core\Controller;
use App\core\Request;
use App\model\UserManagementModel;

class UserController extends Controller
{
    private $userModel;

    public function __construct()
    {
      
        $this->userModel = new UserManagementModel();
    }

    public function userManagement()
    {
        $users = $this->userModel->getAllUsers();

        $this->setLayout('admin/mainAdmin');
        return $this->render('admin/userManagement', [
            'users' => $users
        ]);
    }

    public function saveUser(Request $request)
    {
        if (!$request->isPost()) {
            header('Location: /admin/userManagement');
            exit;
        }

        $data = $request->getBody();

        if (
            empty($data['UserName']) ||
            empty($data['Email']) ||
            empty($data['Phone']) ||
            empty($data['Password'])
        ) {
            $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin!';
            header('Location: /admin/userManagement');
            exit;
        }


        if ($this->userModel->createUser($data)) {
            $_SESSION['success'] = 'Tạo user thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra!';
        }

        header('Location: /admin/userManagement');
        exit;
    }

    public function blockUser(Request $request)
    {
        if (!$request->isPost()) {
            header('Location: /admin/userManagement');
            exit;
        }

        $data = $request->getBody();
        $memberId = $data['MemberID'] ?? null;
        
        if ($memberId) {
            if ($this->userModel->blockUser($memberId)) {
                $_SESSION['success'] = 'Block user thành công!';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra!';
            }
        } else {
            $_SESSION['error'] = 'Không tìm thấy user!';
        }
        
        header('Location: /admin/userManagement');
        exit;
    }

    public function unblockUser(Request $request)
    {
        if (!$request->isPost()) {
            header('Location: /admin/userManagement');
            exit;
        }

        $data = $request->getBody();
        $memberId = $data['MemberID'] ?? null;
        
        if ($memberId) {
            if ($this->userModel->unblockUser($memberId)) {
                $_SESSION['success'] = 'Unblock user thành công!';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra!';
            }
        } else {
            $_SESSION['error'] = 'Không tìm thấy user!';
        }
        
        header('Location: /admin/userManagement');
        exit;
    }
}