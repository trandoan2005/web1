-- ==========================================
-- Lab 6: MiniShop - Cơ sở dữ liệu
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
('Điện thoại', 'Các loại điện thoại thông minh', 'dien-thoai.jpg', 1),
('Laptop', 'Máy tính xách tay các loại', 'laptop.jpg', 1),
('Tablet', 'Máy tính bảng', 'tablet.jpg', 1),
('Phụ kiện', 'Phụ kiện điện tử', 'phu-kien.jpg', 1),
('Đồng hồ thông minh', 'Smartwatch các loại', 'dong-ho.jpg', 1);

-- Thương hiệu
INSERT INTO brands (name, logo, status) VALUES
('Apple', 'apple.png', 1),
('Samsung', 'samsung.png', 1),
('Xiaomi', 'xiaomi.png', 1),
('Dell', 'dell.png', 1),
('Sony', 'sony.png', 1);

-- Sản phẩm
INSERT INTO products (category_id, brand_id, name, slug, old_price, sale_price, quantity, description, image, status) VALUES
(1, 1, 'iPhone 15 Pro Max', 'iphone-15-pro-max', 34990000, 32990000, 50, 'iPhone 15 Pro Max 256GB chính hãng', 'iphone15promax.jpg', 1),
(1, 2, 'Samsung Galaxy S24 Ultra', 'samsung-galaxy-s24-ultra', 33990000, 31490000, 35, 'Samsung Galaxy S24 Ultra 256GB', 'galaxys24ultra.jpg', 1),
(2, 4, 'Dell XPS 15', 'dell-xps-15', 42990000, 39990000, 20, 'Laptop Dell XPS 15 Core i7', 'dellxps15.jpg', 1),
(1, 3, 'Xiaomi 14 Ultra', 'xiaomi-14-ultra', 23990000, 21990000, 40, 'Xiaomi 14 Ultra 512GB', 'xiaomi14ultra.jpg', 1),
(2, 1, 'MacBook Air M3', 'macbook-air-m3', 32990000, 29990000, 25, 'MacBook Air M3 15 inch', 'macbookairm3.jpg', 1),
(3, 2, 'Samsung Galaxy Tab S9', 'samsung-galaxy-tab-s9', 19990000, 17990000, 30, 'Galaxy Tab S9 WiFi', 'galaxytabs9.jpg', 1),
(3, 1, 'iPad Pro M4', 'ipad-pro-m4', 28990000, 27490000, 15, 'iPad Pro M4 11 inch', 'ipadprom4.jpg', 1),
(4, 1, 'AirPods Pro 2', 'airpods-pro-2', 6990000, 5990000, 100, 'Tai nghe AirPods Pro 2 USB-C', 'airpodspro2.jpg', 1),
(4, 2, 'Samsung Galaxy Buds3 Pro', 'samsung-galaxy-buds3-pro', 5990000, 4990000, 60, 'Tai nghe Galaxy Buds3 Pro', 'galaxybuds3pro.jpg', 1),
(5, 1, 'Apple Watch Series 9', 'apple-watch-series-9', 11990000, 10490000, 45, 'Apple Watch Series 9 GPS 45mm', 'applewatchs9.jpg', 1);

-- Ảnh sản phẩm
INSERT INTO product_images (product_id, image_url, sort_order) VALUES
(1, 'iphone15promax_1.jpg', 1),
(1, 'iphone15promax_2.jpg', 2),
(2, 'galaxys24ultra_1.jpg', 1),
(3, 'dellxps15_1.jpg', 1),
(4, 'xiaomi14ultra_1.jpg', 1);

-- Users
INSERT INTO users (username, password, fullname, email, phone, role, status) VALUES
('admin', '123456', 'Quản trị viên', 'admin@minishop.com', '0901111111', 'admin', 1),
('staff1', '123456', 'Nhân viên 1', 'staff1@minishop.com', '0902222222', 'staff', 1),
('staff2', '123456', 'Nhân viên 2', 'staff2@minishop.com', '0903333333', 'staff', 1),
('manager', '123456', 'Quản lý', 'manager@minishop.com', '0904444444', 'manager', 1),
('editor', '123456', 'Biên tập viên', 'editor@minishop.com', '0905555555', 'editor', 1);

-- Khách hàng
INSERT INTO customers (fullname, email, phone, address, status) VALUES
('Nguyễn Văn An', 'nva@gmail.com', '0911111111', '123 Lê Lợi, Q.1, TP.HCM', 1),
('Trần Thị Bình', 'ttb@gmail.com', '0922222222', '456 Nguyễn Huệ, Q.1, TP.HCM', 1),
('Lê Hoàng Cường', 'lhc@gmail.com', '0933333333', '789 Trần Hưng Đạo, Q.5, TP.HCM', 1),
('Phạm Thị Dung', 'ptd@gmail.com', '0944444444', '321 Hai Bà Trưng, Q.3, TP.HCM', 1),
('Hoàng Văn Em', 'hve@gmail.com', '0955555555', '654 Võ Văn Tần, Q.3, TP.HCM', 1);

-- Đơn hàng
INSERT INTO orders (customer_id, total_amount, status, note) VALUES
(1, 32990000, 'Đã giao', 'Giao nhanh'),
(2, 31490000, 'Đang giao', NULL),
(3, 39990000, 'Chờ xử lý', 'Gọi trước khi giao'),
(4, 5990000, 'Đã giao', NULL),
(5, 27490000, 'Đã hủy', 'Khách hủy đơn');

-- Chi tiết đơn hàng
INSERT INTO order_details (order_id, product_id, quantity, price) VALUES
(1, 1, 1, 32990000),
(2, 2, 1, 31490000),
(3, 3, 1, 39990000),
(4, 8, 1, 5990000),
(5, 7, 1, 27490000);
