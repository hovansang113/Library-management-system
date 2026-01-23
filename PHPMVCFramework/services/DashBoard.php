<?php 
namespace App\services;

use App\model\Loan;
use App\model\Book;
use App\model\User;
use App\model\BookCopy;

class DashBoard{    
    protected $loanModel;
    protected $bookModel;
    protected $userModel;
    protected $bookCopyModel;

    public function __construct(){
        $this->loanModel = new Loan();
        $this->bookModel = new Book();
        $this->userModel = new User();
        $this->bookCopyModel = new BookCopy();
    }

    public function getDashboardData(){
        $totalLoans = $this->loanModel->getAllLoans();
        $totalBooks = $this->bookModel->getTotalBook();
        $totalUsers = $this->userModel->countUsers();
        $totalAvailableCopies = $this->bookCopyModel->countAvailableCopies();
        $totalBorrowedCopies = $this->bookCopyModel->countBorrowedCopies();
        return [

            'totalBooks' => $totalBooks,
            'totalUsers' => $totalUsers,
            'totalAvailableCopies' => $totalAvailableCopies,
            'totalBorrowedCopies' => $totalBorrowedCopies
        ];
    }
}
