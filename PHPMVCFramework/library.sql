-- Active: 1768190017597@@127.0.0.1@3306@library_db
-- =========================
-- Create Database
-- =========================
CREATE DATABASE IF NOT EXISTS library_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE library_db;

-- =========================
-- Table: Category
-- =========================
CREATE TABLE Category (
    CategoryID INT AUTO_INCREMENT PRIMARY KEY,
    CategoryName VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- =========================
-- Table: Book
-- =========================
CREATE TABLE Book (
    BookID INT AUTO_INCREMENT PRIMARY KEY,
    CategoryID INT NOT NULL,
    Title VARCHAR(50) NOT NULL,
    Author VARCHAR(50) NOT NULL,
    Image VARCHAR(225),
    Description VARCHAR(225),
    Quantity INT NOT NULL DEFAULT 0,

    CONSTRAINT fk_book_category
        FOREIGN KEY (CategoryID)
        REFERENCES Category(CategoryID)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE INDEX idx_book_category ON Book(CategoryID);

-- =========================
-- Table: Book_Copy
-- =========================
CREATE TABLE Book_Copy (
    CopyID INT AUTO_INCREMENT PRIMARY KEY,
    BookID INT NOT NULL,
    Status ENUM('Available', 'Borrowed') NOT NULL DEFAULT 'Available',

    CONSTRAINT fk_copy_book
        FOREIGN KEY (BookID)
        REFERENCES Book(BookID)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE INDEX idx_copy_book ON Book_Copy(BookID);

-- =========================
-- Table: Member
-- =========================
CREATE TABLE Member (
    MemberID INT AUTO_INCREMENT PRIMARY KEY,
    UserName VARCHAR(50) NOT NULL,
    Phone VARCHAR(15),
    Email VARCHAR(50) UNIQUE,
    RegisterDate DATE NOT NULL,
    Password VARCHAR(255) NOT NULL,
    Status ENUM('Active', 'Blocked') NOT NULL DEFAULT 'Active',
    Role ENUM('User', 'Admin') NOT NULL DEFAULT 'User'
) ENGINE=InnoDB;
INSERT INTO Member (UserName, Phone, Email, RegisterDate, Password, Status, Role) 
VALUES (
    'Nguyen Van A', 
    '0901234567', 
    'test@gmail.com', 
    CURDATE(), 
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
    'Active', 
    'User'
);

-- =========================
-- Table: Loan
-- =========================
CREATE TABLE Loan (
    LoanID INT AUTO_INCREMENT PRIMARY KEY,
    MemberID INT NOT NULL,
    CopyID INT NOT NULL,
    BorrowDate DATE NOT NULL,
    ReturnDate DATE,
    DueDate DATE NOT NULL,
    Status ENUM('Borrowed', 'Returned') NOT NULL DEFAULT 'Borrowed',

    CONSTRAINT fk_loan_member
        FOREIGN KEY (MemberID)
        REFERENCES Member(MemberID)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_loan_copy
        FOREIGN KEY (CopyID)
        REFERENCES Book_Copy(CopyID)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE INDEX idx_loan_member ON Loan(MemberID);
CREATE INDEX idx_loan_copy ON Loan(CopyID);

INSERT INTO Category (CategoryName) VALUES 
('Văn học'),
('Khoa học'),
('Lịch sử');
INSERT INTO Category (CategoryName) VALUES 
('Tiểu thuyết'),
('Triết học');
DELETE FROM Book
WHERE BookID BETWEEN 1 AND 10;
INSERT INTO Book (CategoryID, Title, Author, Image, Description, Quantity) VALUES 
(1, 'Truyện Kiều', 'Nguyễn Du', 'img/homepage/item/book2.jpg', 'Tác phẩm văn học kinh điển Việt Nam', 5),
(4, 'Harry Potter', 'J.K. Rowling', 'img/homepage/item/book3.jpg', 'Phù thủy học đường Hogwarts', 8),
(2, 'Vũ trụ trong vỏ hạt dẻ', 'Stephen Hawking', 'img/homepage/item/book4.jpg', 'Khám phá bí ẩn vũ trụ', 3),
(3, 'Lược sử loài người', 'Yuval Noah Harari', 'img/homepage/item/book5.jpg', 'Từ động vật đến chúa tể', 6),
(1, 'Số đỏ', 'Vũ Trọng Phụng', 'img/homepage/item/book6.jpg', 'Hiện thực xã hội Hà Nội xưa', 4),
(4, 'Nhà giả kim', 'Paulo Coelho', 'img/homepage/item/book7.jpg', 'Hành trình tìm kiếm kho báu', 10),
(5, 'Đắc nhân tâm', 'Dale Carnegie', 'img/homepage/item/book8.jpg', 'Nghệ thuật giao tiếp và ứng xử', 7),
(2, 'Sapiens', 'Yuval Noah Harari', 'img/homepage/item/book9.jpg', 'Lịch sử nhân loại', 5),
(3, 'Dế Mèn phiêu lưu ký', 'Tô Hoài', 'img/homepage/item/book10.jpg', 'Truyện thiếu nhi nổi tiếng', 6),
(4, 'Tôi thấy hoa vàng trên cỏ xanh', 'Nguyễn Nhật Ánh', 'img/homepage/item/book11.jpg', 'Tuổi thơ dữ dội của Thiều', 9);
UPDATE Book
SET Image = CONCAT('/', Image)
WHERE BookID > 0
  AND Image NOT LIKE '/%';



-- =========================
-- Tạo Trigger tự động thêm Book_Copy
-- =========================
DELIMITER $$

CREATE TRIGGER after_book_insert
AFTER INSERT ON Book
FOR EACH ROW
BEGIN
    DECLARE i INT DEFAULT 0;
    WHILE i < NEW.Quantity DO
        INSERT INTO Book_Copy (BookID, Status) 
        VALUES (NEW.BookID, 'Available');
        SET i = i + 1;
    END WHILE;
END$$

DELIMITER ;

-- =========================
-- Kiểm tra kết quả
-- =========================
SELECT 
    b.BookID,
    b.Title,
    b.Author,
    b.Image,
    b.Quantity,
    c.CategoryName,
    COUNT(bc.CopyID) as TotalCopies,
    SUM(CASE WHEN bc.Status = 'Available' THEN 1 ELSE 0 END) as AvailableCopies
FROM Book b
LEFT JOIN Category c ON b.CategoryID = c.CategoryID
LEFT JOIN Book_Copy bc ON b.BookID = bc.BookID
GROUP BY b.BookID
ORDER BY b.BookID;


-- Xem chi tiết Book_Copy
SELECT * FROM Book_Copy ORDER BY BookID, CopyID;

SELECT * FROM Member;
SELECT * FROM Loan;
SELECT * FROM Book;
SELECT * FROM Book_Copy;
SELECT * FROM Category;
