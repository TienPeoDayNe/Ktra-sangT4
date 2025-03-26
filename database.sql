-- Tạo cơ sở dữ liệu
CREATE DATABASE IF NOT EXISTS webbanhang CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE webbanhang;

-- Tạo bảng categories
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo bảng products
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    category_id INT,
    stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm một số danh mục mẫu
INSERT INTO categories (name, description) VALUES
('Điện thoại', 'Các loại điện thoại di động'),
('Laptop', 'Máy tính xách tay các loại'),
('Phụ kiện', 'Phụ kiện điện tử'),
('Tablet', 'Máy tính bảng các loại');

-- Thêm một số sản phẩm mẫu
INSERT INTO products (name, description, price, category_id, stock) VALUES
('iPhone 13', 'iPhone 13 128GB chính hãng VN/A', 19990000, 1, 10),
('Samsung Galaxy S21', 'Samsung Galaxy S21 Ultra 5G', 25990000, 1, 5),
('MacBook Pro M1', 'Laptop Apple MacBook Pro M1 2020', 31990000, 2, 8),
('Dell XPS 13', 'Dell XPS 13 9310 i7 1165G7', 41990000, 2, 3),
('AirPods Pro', 'Tai nghe Bluetooth AirPods Pro', 4990000, 3, 15),
('iPad Pro M1', 'Máy tính bảng iPad Pro M1 11 inch', 19990000, 4, 7); 