-- ==========================================
-- Lab 6: GàĐáShop - Cơ sở dữ liệu
-- Database: tranvandoan_database
-- ==========================================

CREATE DATABASE IF NOT EXISTS tranvandoan_database
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE tranvandoan_database;

-- ==========================================
-- Bảng categories (Danh mục sản phẩm)
-- ==========================================
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NULL,
    image VARCHAR(255) NULL,
    status TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- Bảng brands (Thương hiệu)
-- ==========================================
CREATE TABLE IF NOT EXISTS brands (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    logo VARCHAR(255) NULL,
    status TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- Bảng products (Sản phẩm)
-- ==========================================
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    brand_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NULL,
    old_price DECIMAL(15,0) NOT NULL DEFAULT 0,
    sale_price DECIMAL(15,0) NOT NULL DEFAULT 0,
    quantity INT NOT NULL DEFAULT 0,
    description TEXT NULL,
    image VARCHAR(255) NULL,
    status TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (brand_id) REFERENCES brands(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- Bảng product_images (Ảnh sản phẩm)
-- ==========================================
CREATE TABLE IF NOT EXISTS product_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- Bảng users (Người dùng quản trị)
-- ==========================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NULL,
    phone VARCHAR(20) NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'admin',
    status TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- Bảng customers (Khách hàng)
-- ==========================================
CREATE TABLE IF NOT EXISTS customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NULL,
    phone VARCHAR(20) NULL,
    address TEXT NULL,
    status TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- Bảng orders (Đơn hàng)
-- ==========================================
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    total_amount DECIMAL(15,0) NOT NULL DEFAULT 0,
    status VARCHAR(30) NOT NULL DEFAULT 'Chờ xử lý',
    note TEXT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- Bảng order_details (Chi tiết đơn hàng)
-- ==========================================
CREATE TABLE IF NOT EXISTS order_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    price DECIMAL(15,0) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- DỮ LIỆU MẪU
-- ==========================================

-- Danh mục
INSERT INTO categories (name, description, image, status) VALUES
('Gà Nòi Chiến', 'Các giống gà nòi thuần chủng chuyên đá', 'ga-noi-chien.jpg', 1),
('Gà Chọi Lai', 'Gà lai tạo giữa các dòng gà chiến', 'ga-choi-lai.jpg', 1),
('Thức Ăn & Dinh Dưỡng', 'Cám, thóc, vitamin bổ sung cho gà đá', 'thuc-an.jpg', 1),
('Phụ Kiện & Dụng Cụ', 'Cựa sắt, bao cát, dây buộc, lồng tập', 'phu-kien.jpg', 1),
('Thuốc & Chăm Sóc', 'Thuốc bổ, thuốc trị thương, dầu xoa bóp cho gà', 'thuoc-cham-soc.jpg', 1);

-- Thương hiệu (Dòng gà / Xuất xứ)
INSERT INTO brands (name, logo, status) VALUES
('Gà Bình Định', 'ga-binh-dinh.png', 1),
('Gà Đòn Tây Sơn', 'ga-don-tay-son.png', 1),
('Gà Tre Mỹ', 'ga-tre-my.png', 1),
('Gà Peru', 'ga-peru.png', 1),
('Gà Asil Ấn Độ', 'ga-asil.png', 1);

-- Sản phẩm (Gà đá + phụ kiện)
INSERT INTO products (category_id, brand_id, name, slug, old_price, sale_price, quantity, description, image, status) VALUES
(1, 1, 'Gà Nòi Bình Định Điều Đỏ', 'ga-noi-binh-dinh-dieu-do', 5000000, 4500000, 10, 'Gà nòi thuần Bình Định, lông điều đỏ, chân vàng, thể hình chuẩn. Đã tập luyện 6 tháng, đá cựa sắc bén.', 'ga-noi-dieu-do.jpg', 1),
(1, 2, 'Gà Đòn Tây Sơn Ô Chuối', 'ga-don-tay-son-o-chuoi', 7000000, 6500000, 8, 'Gà đòn dòng Tây Sơn lông ô chuối, đòn nặng, chịu đòn tốt. Đã qua 3 trận thắng liên tiếp.', 'ga-don-o-chuoi.jpg', 1),
(1, 1, 'Gà Nòi Xám Bạc', 'ga-noi-xam-bac', 4500000, 4000000, 12, 'Gà nòi lông xám bạc, mình nhỏ nhưng nhanh nhẹn, đá liên hoàn cực kỳ hiệu quả.', 'ga-noi-xam-bac.jpg', 1),
(2, 3, 'Gà Lai Tre Mỹ F1', 'ga-lai-tre-my-f1', 3500000, 3000000, 15, 'Gà lai F1 giữa gà Tre Mỹ và gà Nòi Việt. Thể hình đẹp, sức bền cao, phù hợp đá cựa.', 'ga-lai-tre-my.jpg', 1),
(2, 4, 'Gà Lai Peru Chân Xanh', 'ga-lai-peru-chan-xanh', 8000000, 7500000, 5, 'Gà lai Peru nhập khẩu, chân xanh, lông đen tuyền. Đòn nặng, sức đá kinh hoàng.', 'ga-lai-peru.jpg', 1),
(2, 5, 'Gà Asil Ấn Độ Thuần Chủng', 'ga-asil-an-do', 12000000, 11000000, 3, 'Gà Asil nhập từ Ấn Độ, dòng chiến binh cổ đại. Cơ bắp cuồn cuộn, đá chết bỏ.', 'ga-asil.jpg', 1),
(3, 1, 'Cám Gà Đá Premium 5kg', 'cam-ga-da-premium', 350000, 300000, 100, 'Cám gà đá cao cấp, giàu protein và vitamin. Giúp gà tăng cơ, bền sức, lông mượt.', 'cam-ga-da.jpg', 1),
(3, 1, 'Thóc Lức Ngâm Mật Ong', 'thoc-luc-ngam-mat-ong', 200000, 180000, 80, 'Thóc lức đỏ ngâm mật ong rừng. Bổ sung năng lượng, tăng sức đề kháng cho gà chiến.', 'thoc-luc.jpg', 1),
(4, 1, 'Cựa Sắt Inox Cao Cấp (Đôi)', 'cua-sat-inox', 500000, 450000, 50, 'Cựa sắt inox không gỉ, sắc bén, thiết kế chuẩn thi đấu. Đã mài sẵn, kèm dây buộc.', 'cua-sat.jpg', 1),
(5, 1, 'Dầu Nóng Xoa Bóp Gà Đá', 'dau-nong-xoa-bop', 150000, 120000, 200, 'Dầu nóng thảo dược chuyên dụng xoa bóp cho gà trước và sau trận đấu. Giảm đau, tan máu bầm.', 'dau-nong.jpg', 1);

-- Ảnh sản phẩm
INSERT INTO product_images (product_id, image_url, sort_order) VALUES
(1, 'ga-noi-dieu-do_1.jpg', 1),
(1, 'ga-noi-dieu-do_2.jpg', 2),
(2, 'ga-don-o-chuoi_1.jpg', 1),
(3, 'ga-noi-xam-bac_1.jpg', 1),
(5, 'ga-lai-peru_1.jpg', 1);

-- Users
INSERT INTO users (username, password, fullname, email, phone, role, status) VALUES
('admin', '123456', 'Chủ Trại Gà', 'admin@gadashop.com', '0901111111', 'admin', 1),
('staff1', '123456', 'Nhân viên chăm gà', 'staff1@gadashop.com', '0902222222', 'staff', 1),
('staff2', '123456', 'Nhân viên bán hàng', 'staff2@gadashop.com', '0903333333', 'staff', 1),
('manager', '123456', 'Quản lý trại', 'manager@gadashop.com', '0904444444', 'manager', 1),
('editor', '123456', 'Biên tập viên', 'editor@gadashop.com', '0905555555', 'editor', 1);

-- Khách hàng
INSERT INTO customers (fullname, email, phone, address, status) VALUES
('Nguyễn Văn Tài', 'nvt@gmail.com', '0911111111', '123 Quốc lộ 1A, Tuy Phước, Bình Định', 1),
('Trần Minh Đức', 'tmd@gmail.com', '0922222222', '456 Nguyễn Huệ, An Nhơn, Bình Định', 1),
('Lê Thanh Sơn', 'lts@gmail.com', '0933333333', '789 Trần Hưng Đạo, Q.5, TP.HCM', 1),
('Phạm Hữu Phước', 'php@gmail.com', '0944444444', '321 Hai Bà Trưng, Quy Nhơn, Bình Định', 1),
('Hoàng Đình Chiến', 'hdc@gmail.com', '0955555555', '654 Võ Văn Tần, Q.3, TP.HCM', 1);

-- Đơn hàng
INSERT INTO orders (customer_id, total_amount, status, note) VALUES
(1, 4500000, 'Đã giao', 'Giao tận trại'),
(2, 6500000, 'Đang giao', NULL),
(3, 7500000, 'Chờ xử lý', 'Gọi trước khi giao, gà cần vận chuyển cẩn thận'),
(4, 300000, 'Đã giao', NULL),
(5, 11000000, 'Đã hủy', 'Khách hủy đơn do thay đổi ý');

-- Chi tiết đơn hàng
INSERT INTO order_details (order_id, product_id, quantity, price) VALUES
(1, 1, 1, 4500000),
(2, 2, 1, 6500000),
(3, 5, 1, 7500000),
(4, 7, 1, 300000),
(5, 6, 1, 11000000);
