-- ==========================================
-- Lab 5: Tạo Database và bảng dữ liệu
-- ==========================================

-- Tạo Database
CREATE DATABASE IF NOT EXISTS tranvandoan_mydb1
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE tranvandoan_mydb1;

-- ==========================================
-- Câu B: Tạo bảng students
-- ==========================================
CREATE TABLE IF NOT EXISTS students (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    studentcode VARCHAR(20) UNIQUE,
    fullname VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NULL,
    gender VARCHAR(10) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm 5 sinh viên
INSERT INTO students (studentcode, fullname, phone, gender) VALUES
('SV001', 'Trần Văn Đoàn', '0901234567', 'Nam'),
('SV002', 'Nguyễn Thị Bích', '0912345678', 'Nữ'),
('SV003', 'Lê Hoàng Nam', '0923456789', 'Nam'),
('SV004', 'Phạm Thị Dung', '0934567890', 'Nữ'),
('SV005', 'Hoàng Văn Em', '0945678901', 'Nam');

-- Cập nhật số điện thoại cho SV001
UPDATE students SET phone = '0999888777' WHERE studentcode = 'SV001';

-- Xóa sinh viên SV002
DELETE FROM students WHERE studentcode = 'SV002';

-- ==========================================
-- Câu B: Tạo bảng courses bằng câu lệnh SQL
-- ==========================================
CREATE TABLE IF NOT EXISTS courses (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    course_code VARCHAR(20),
    course_name VARCHAR(100),
    credits INT,
    tuition_fee DECIMAL(10,0),
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm 5 học phần
INSERT INTO courses (course_code, course_name, credits, tuition_fee) VALUES
('PHP101', 'Lập trình PHP', 3, 2500000),
('WEB201', 'Thiết kế Web', 3, 2500000),
('DB301', 'Cơ sở dữ liệu', 4, 3000000),
('JAVA101', 'Lập trình Java', 3, 2500000),
('NET201', 'Lập trình .NET', 3, 2800000);

-- Xem kết quả
SELECT * FROM courses;

-- Cập nhật học phí PHP101
UPDATE courses SET tuition_fee = 2700000 WHERE course_code = 'PHP101';

-- Xóa học phần WEB201
DELETE FROM courses WHERE course_code = 'WEB201';
