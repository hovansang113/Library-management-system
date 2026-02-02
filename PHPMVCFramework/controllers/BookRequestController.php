<?php

namespace App\controllers;

use App\core\Controller;
use App\core\Request;
use App\model\Book_request;

class BookRequestController extends Controller
{
    public function handleBookRequest(Request $request)
    {
        // Ensure user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $bookRequestModel = new Book_request();
        $userId = $_SESSION['user_id'];

        if ($request->isPost()) {
            $body = $request->getBody();

            // Validation and data mapping for the model
            if (!empty($body['book_name'])) {
                $dataToCreate = [
                    'MemberID' => $userId,
                    'Title'    => $body['book_name'],
                    'Author'   => $body['author'] ?? '', // Author can be optional
                    'Reason'   => $body['reason'] ?? ''  // Reason can be optional
                ];

                if ($bookRequestModel->create($dataToCreate)) {
                    $_SESSION['success'] = 'Yêu cầu của bạn đã được gửi thành công!';
                } else {
                    $_SESSION['error'] = 'Gửi yêu cầu thất bại. Vui lòng thử lại.';
                }
            } else {
                $_SESSION['error'] = 'Tiêu đề sách không được để trống.';
            }

            // Redirect to the same page to show the new request and prevent form resubmission
            header('Location: /bookRequest');
            exit;
        }

        // For GET requests, fetch and display the user's requests
        $requests = $bookRequestModel->getRequestsByUserId($userId);

        return $this->render('bookRequest', [
            'requests' => $requests
        ]);
    }
}
