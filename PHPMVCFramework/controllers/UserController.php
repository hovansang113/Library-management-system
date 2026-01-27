<?php

namespace App\controllers;

use App\core\Controller;
use App\core\Request;
use App\model\User;

class UserController extends Controller
{
    private $userModel;

    public function __construct()
    {

        $this->userModel = new User();
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

    public function changePassword(Request $request)
    {
        if (!$request->isPost()) {
            header('Location: /profile');
            exit;
        }

        $data = $request->getBody();
        $currentPassword = $data['currentPassword'] ?? '';
        $newPassword = $data['newPassword'] ?? '';
        $confirmNewPassword = $data['confirmNewPassword'] ?? '';
        $memberId = $_SESSION['user_id'];

        if (empty($currentPassword) || empty($newPassword) || empty($confirmNewPassword)) {
            $_SESSION['error'] = 'Please fill in all required fields!';
            $_SESSION['error'] = 'Vui lòng điền đầy đủ các trường!';
            header('Location: /profile');
            exit;
        }

        if ($newPassword !== $confirmNewPassword) {
            $_SESSION['error'] = 'New password does not match!';
            $_SESSION['error'] = 'Mật khẩu mới không khớp!';
            header('Location: /profile');
            exit;
        }

        $user = $this->userModel->getUserById($memberId);

        if (!$user) {
            $_SESSION['error'] = 'User not found!';
        if (!$this->userModel->verifyCurrentPassword($memberId, $currentPassword)) {
            $_SESSION['error'] = 'Mật khẩu hiện tại không đúng!';
            header('Location: /profile');
            exit;
        }

        if (!password_verify($currentPassword, $user['Password'])) {
            $_SESSION['error'] = 'Current password is incorrect!';
            header('Location: /profile');
            exit;
        }

        if ($this->userModel->updatePassword($memberId, $newPassword)) {
            $_SESSION['success'] = 'Password changed successfully!';
            $_SESSION['success'] = 'Đổi mật khẩu thành công!';
        } else {
            $_SESSION['error'] = 'An error occurred while changing the password!';
            $_SESSION['error'] = 'Có lỗi xảy ra khi đổi mật khẩu!';
        }

        header('Location: /profile');
        exit;
    }

}
}
