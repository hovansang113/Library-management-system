# Library Management System

A comprehensive library management system developed using native PHP following the MVC (Model–View–Controller) architecture.
The system provides efficient management of books, categories, members, and the borrowing–returning process. With a clear structure and user-friendly interface, the project helps optimize library operations, improve user experience, and minimize errors in daily management tasks.

## Introduction
**Library-management-system** is a lightweight web application built without relying on large frameworks. It is designed to help learners gain a practical understanding of the MVC architecture, PDO, and relational database structures in real-world web development.

## Project Team

- Hồ Văn Sang
- Nguyễn Tiến Nhựt
- Y Kim Trâm


## Key Features

- **Authentication:** System login with email/username and password validation, supporting both Admin and Member roles with secure session management.
- **Admin Dashboard:** Overview of library activities with summary statistics (total books, borrowed books, available books, total members).
- **Book Inventory Management:** Admin can add, edit, delete, and view all books in the library with automatic quantity and status updates.
- **Member Management:** Admin can create new member accounts, update information, and manage account status (Active/Inactive).
- **Catalog Browsing & Search:** Members can search books by title or author and filter by category or availability status.
- **Book Details:** Members can view detailed information about books including title, author, category, description, and status.
- **Borrowing Process:** Admin can process book borrowing transactions with automatic inventory updates and validation checks.
- **Return Process:** Admin can process book returns with automatic inventory updates and transaction tracking.
- **Member Dashboard:** Members can view borrowed books, expected return dates, and borrowing history.
- **Circulation Tracking:** Admin can view and manage all borrowing/returning transactions with filtering options and overdue status marking.
- **Book Request System:** Members can submit book borrowing requests for available books, with request status tracking (Pending/Approved/Rejected).
- **Request Approval:** Admin can approve or reject book requests with automatic borrowing record creation and member notifications.
- **Change Password:** Members can securely change their password with validation rules for password strength.
- **System Administration & Security:** Authentication, role-based authorization (Admin vs Member), and comprehensive session management.

## Technologies Used

- **Language:** PHP (MVC Pattern)
- **Database:** MySQL (Uses PDO and Singleton Pattern)
- **Frontend:** HTML, CSS, JavaScript

## Folder Structure

```
Library-management-system/
├── PHPMVCFramework/
│   ├── controllers/
│   ├── core/
│   ├── model/
│   ├── public/
│   │   └── css/
│   │       └── admin/
│   │   └── js/
│   │       └── admin/
│   │   └── img/
│   │       └── homepage/
│   ├── runtime/
│   ├── vendor/
│   │   ├── graham-campbell/
│   │   ├── phpoption/
│   │   ├── symfony/
│   │   └── vlucas/
│   └── view/
│       ├── admin/
│       └── layouts/
│           └── Admin/
```