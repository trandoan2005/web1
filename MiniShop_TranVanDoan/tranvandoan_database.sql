-- ==========================================
-- Lab 6: ShoeShop - Cơ sở dữ liệu
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
    password VARCHAR(255) NULL,
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
('Giày Sneaker', 'Giày thể thao sneaker chính hãng các thương hiệu lớn', 'sneaker.jpg', 1),
('Giày Chạy Bộ', 'Giày chạy bộ chuyên dụng, công nghệ đệm cao cấp', 'running.jpg', 1),
('Giày Bóng Rổ', 'Giày bóng rổ performance và lifestyle', 'basketball.jpg', 1),
('Giày Đá Bóng', 'Giày đá bóng sân cỏ tự nhiên và nhân tạo', 'football.jpg', 1),
('Dép & Sandal', 'Dép và sandal thể thao chính hãng', 'sandal.jpg', 1);

-- Thương hiệu
INSERT INTO brands (name, logo, status) VALUES
('Nike', 'nike.png', 1),
('Adidas', 'adidas.png', 1),
('Jordan', 'jordan.png', 1),
('New Balance', 'new-balance.png', 1),
('Puma', 'puma.png', 1);

-- Sản phẩm
INSERT INTO products (category_id, brand_id, name, slug, old_price, sale_price, quantity, description, image, status) VALUES
(1, 1, 'Nike Air Force 1 ''07 White', 'nike-air-force-1-07-white', 3200000, 2890000, 50, 'Giày Nike Air Force 1 ''07 màu trắng nguyên bản, chất liệu da cao cấp, đế Air êm ái. Icon kinh điển không bao giờ lỗi thời.', 'nike-af1-white.jpg', 1),
(1, 2, 'Adidas Stan Smith White Green', 'adidas-stan-smith-white-green', 2800000, 2490000, 40, 'Adidas Stan Smith phối trắng xanh cổ điển, upper da thật mềm mại, đế cao su bền bỉ. Biểu tượng thời trang từ 1971.', 'adidas-stan-smith.jpg', 1),
(1, 3, 'Air Jordan 1 Retro High OG Chicago', 'jordan-1-retro-high-chicago', 5500000, 4990000, 15, 'Jordan 1 Retro High OG phối màu Chicago huyền thoại. Da premium, cổ cao bảo vệ mắt cá chân. Phiên bản giới hạn.', 'jordan-1-chicago.jpg', 1),
(2, 1, 'Nike Air Zoom Pegasus 41', 'nike-pegasus-41', 3800000, 3290000, 35, 'Giày chạy bộ Nike Pegasus 41 với công nghệ Zoom Air và React foam. Thoáng khí, nhẹ, phù hợp chạy hàng ngày.', 'nike-pegasus-41.jpg', 1),
(2, 2, 'Adidas Ultraboost Light', 'adidas-ultraboost-light', 4500000, 3890000, 25, 'Adidas Ultraboost Light với đệm Boost nhẹ nhất từ trước đến nay, upper Primeknit+ ôm chân hoàn hảo. Chạy bộ êm như mây.', 'adidas-ultraboost.jpg', 1),
(3, 1, 'Nike LeBron 21', 'nike-lebron-21', 5200000, 4690000, 20, 'Nike LeBron 21 với Zoom Air ở tiền bàn chân và Air Max ở gót. Bám sân tốt, hỗ trợ chuyển hướng nhanh trên sân bóng rổ.', 'nike-lebron-21.jpg', 1),
(3, 3, 'Air Jordan 4 Retro Thunder', 'jordan-4-retro-thunder', 6800000, 5990000, 10, 'Jordan 4 Retro phối màu Thunder (đen vàng). Da nubuck cao cấp, đệm Air Sole, thiết kế cage bên hông đặc trưng.', 'jordan-4-thunder.jpg', 1),
(4, 1, 'Nike Mercurial Superfly 9 Elite FG', 'nike-mercurial-superfly-9', 6500000, 5790000, 18, 'Giày đá bóng Nike Mercurial Superfly 9 Elite sân cỏ tự nhiên. Vaporposite upper siêu nhẹ, Zoom Air đệm gót, tốc độ tối đa.', 'nike-mercurial.jpg', 1),
(4, 2, 'Adidas Predator Elite FG', 'adidas-predator-elite-fg', 5800000, 5190000, 22, 'Adidas Predator Elite cho sân cỏ tự nhiên. Upper Hybridtouch kiểm soát bóng chuẩn xác, đế Facetframe ổn định.', 'adidas-predator.jpg', 1),
(5, 1, 'Nike Air Max 90 Slide', 'nike-air-max-90-slide', 1800000, 1490000, 60, 'Dép Nike Air Max 90 Slide với đệm Air Max huyền thoại. Quai da tổng hợp bền chắc, êm chân cả ngày dài.', 'nike-slide.jpg', 1);

-- Ảnh sản phẩm
INSERT INTO product_images (product_id, image_url, sort_order) VALUES
(1, 'nike-af1-white_1.jpg', 1),
(1, 'nike-af1-white_2.jpg', 2),
(2, 'adidas-stan-smith_1.jpg', 1),
(3, 'jordan-1-chicago_1.jpg', 1),
(5, 'adidas-ultraboost_1.jpg', 1);

-- Users
INSERT INTO users (username, password, fullname, email, phone, role, status) VALUES
('admin', '123456', 'Quản trị viên', 'admin@shoeshop.vn', '0901111111', 'admin', 1),
('staff1', '123456', 'Nhân viên bán hàng', 'staff1@shoeshop.vn', '0902222222', 'staff', 1),
('staff2', '123456', 'Nhân viên kho', 'staff2@shoeshop.vn', '0903333333', 'staff', 1),
('manager', '123456', 'Quản lý cửa hàng', 'manager@shoeshop.vn', '0904444444', 'manager', 1),
('editor', '123456', 'Biên tập nội dung', 'editor@shoeshop.vn', '0905555555', 'editor', 1);

-- Khách hàng
INSERT INTO customers (fullname, email, phone, address, status) VALUES
('Nguyễn Minh Khang', 'nmk@gmail.com', '0911111111', '123 Nguyễn Trãi, Q.1, TP.HCM', 1),
('Trần Thị Hương', 'tth@gmail.com', '0922222222', '456 Lê Văn Sỹ, Q.3, TP.HCM', 1),
('Lê Quốc Bảo', 'lqb@gmail.com', '0933333333', '789 Cách Mạng Tháng 8, Q.10, TP.HCM', 1),
('Phạm Anh Tuấn', 'pat@gmail.com', '0944444444', '321 Trần Đại Nghĩa, Q.Bình Thạnh, TP.HCM', 1),
('Hoàng Thu Trang', 'htt@gmail.com', '0955555555', '654 Phạm Văn Đồng, Q.Thủ Đức, TP.HCM', 1);

-- Đơn hàng
INSERT INTO orders (customer_id, total_amount, status, note) VALUES
(1, 4990000, 'Đã giao', 'Size 42, giao nhanh'),
(2, 2490000, 'Đang giao', NULL),
(3, 3290000, 'Chờ xử lý', 'Size 41, check hàng trước khi giao'),
(4, 5790000, 'Đã giao', NULL),
(5, 5990000, 'Đã hủy', 'Khách đổi ý, muốn size khác');

-- Chi tiết đơn hàng
INSERT INTO order_details (order_id, product_id, quantity, price) VALUES
(1, 3, 1, 4990000),
(2, 2, 1, 2490000),
(3, 4, 1, 3290000),
(4, 8, 1, 5790000),
(5, 7, 1, 5990000);
