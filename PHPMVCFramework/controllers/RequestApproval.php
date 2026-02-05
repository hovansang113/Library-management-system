<?php

namespace App\controllers;

use App\core\Controller;
use App\core\Request;
use App\model\Book_request;

class RequestApproval extends Controller{

    public function requestApproval(){
        $bookRequestModel = new Book_request();
        $requests = $bookRequestModel->getAllRequestsWithUserDetails();
        $stats = $bookRequestModel->getRequestStats();

        $this->setLayout('admin/mainAdmin');
        return $this->render('admin/requestApproval', [
            'requests' => $requests,
            'stats' => $stats
        ]);
    }

    public function approveRequest(Request $request)
    {
        $data = $request->getBody();
        $requestId = $data['request_id'] ?? null;

        if ($requestId) {
            $bookRequestModel = new Book_request();
            $bookRequestModel->updateStatus($requestId, 'Approved');
            $_SESSION['success'] = 'Yêu cầu đã được duyệt thành công!';
        } else {
            $_SESSION['error'] = 'ID yêu cầu không hợp lệ.';
        }

        header('Location: /admin/requestApproval');
        exit;
    }

    public function rejectRequest(Request $request)
    {
        $data = $request->getBody();
        $requestId = $data['request_id'] ?? null;

        if ($requestId) {
            $bookRequestModel = new Book_request();
            $bookRequestModel->updateStatus($requestId, 'Rejected');
            $_SESSION['success'] = 'Yêu cầu đã được từ chối.';
        } else {
            $_SESSION['error'] = 'ID yêu cầu không hợp lệ.';
        }

        header('Location: /admin/requestApproval');
        exit;
    }
}