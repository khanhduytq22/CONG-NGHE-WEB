CREATE DATABASE managerment;
USE managerment;

CREATE TABLE prod (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    size VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO prod (name, price,) VALUES
('Sản phẩm A', 1500.00),
('Sản phẩm B', 2500.00),
('Sản phẩm C', 3500.00);

ALTER TABLE prod ADD COLUMN description TEXT;
ALTER TABLE prod ADD COLUMN image VARCHAR(255);

