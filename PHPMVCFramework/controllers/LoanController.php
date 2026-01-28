<?php
namespace App\controllers;
use App\core\Controller;
use App\core\Request;
use App\model\Loan;
use App\model\Book;
use App\model\User;


class LoanController extends Controller
{
    public function loanManagement()
    {
        $bookModel = new Book();
        $userModel = new User();
        $loanModel = new Loan();
        $loan = $loanModel->getAllLoans();
        $books = $bookModel->getBookName();
        $users = $userModel->getAllUsers();
        $this->setLayout('admin/mainAdmin');
        return $this->render('admin/loanMangement', [
            'books' => $books,
            'members' => $users,
            'loans' => $loan
        ]);
    }

    public function loanProcess(Request $request){
        $data = $request->getBody();
        $member_id = $data['user_id'] ?? null;
        $book_id = $data['book_id'] ?? null;    
        $due_date = $data['expected_return_date'] ?? null;

        if (!$member_id || !$book_id || !$due_date) {
            die("Missing required data");
        }

        $loanModel = new Loan();

        $copy_id = $loanModel->getAvailableCopy($book_id);

        if (!$copy_id) {
            die("No available copies for this book");
        }

        $loanModel->createLoan($member_id, $copy_id, $due_date);
        $loanModel->markCopyBorrowed($copy_id);

        header("Location: /admin/loanManagement");
        exit;
    }

    public function returnBook(Request $request){
        $data = $request->getBody();
        $loan_id = $data['loan_id'] ?? null;

        if ($loan_id) {
            $loanModel = new Loan();
            $copy_id = $loanModel->getCopyIdByLoan($loan_id);

            if ($copy_id) {
                $loanModel->updateLoanStatus($loan_id);
                $loanModel->markCopyReturned($copy_id);
            }
        }

        header("Location: /admin/loanManagement");
        exit;
    }

    public function userLoans()
    {
        return $this->render('member/member-dashboard');
    }

    public function currentLoans()
    {
        return $this->render('member/current-loans');
    }   
    public function borrowingHistory()
    {
        return $this->render('member/borrowing-history');
    }
}