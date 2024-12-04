<?php

class ProductModel
{
    // Khởi tạo danh sách sản phẩm trong session nếu chưa có
    public static function initializeProducts()
    {
        if (!isset($_SESSION['products'])) {
            $_SESSION['products'] = [
                ['id' => 1, 'name' => 'Sản phẩm 1', 'price' => 1000],
                ['id' => 2, 'name' => 'Sản phẩm 2', 'price' => 2000],
                ['id' => 3, 'name' => 'Sản phẩm 3', 'price' => 30200]
            ];
        }
    }

    // Lấy danh sách sản phẩm
    public static function getAllProducts()
    {
        return $_SESSION['products'] ?? [];
    }

    // Lấy sản phẩm theo ID
    public static function getProductById($id)
    {
        foreach ($_SESSION['products'] as $product) {
            if ($product['id'] == $id) {
                return $product;
            }
        }
        return null;
    }

    // Thêm sản phẩm mới
    public static function addProduct($name, $price)
    {
        $id = end($_SESSION['products'])['id'] + 1; // Tự động tăng ID
        $_SESSION['products'][] = ['id' => $id, 'name' => $name, 'price' => $price];
    }

    public static function updateProduct($id, $name, $price) {
        // Kiểm tra nếu session có dữ liệu
        if (isset($_SESSION['products'])) {
            // Duyệt qua tất cả các sản phẩm trong session và cập nhật sản phẩm có ID tương ứng
            foreach ($_SESSION['products'] as &$product) {
                if ($product['id'] == $id) {
                    $product['name'] = $name;
                    $product['price'] = $price;
                    break;
                }
            }
        }
    }
    
    

   // Model
public static function deleteProduct($id) {
    // Kiểm tra nếu session có dữ liệu
    if (isset($_SESSION['products'])) {
        // Lọc sản phẩm để xóa sản phẩm có ID tương ứng
        $_SESSION['products'] = array_filter($_SESSION['products'], function($product) use ($id) {
            return $product['id'] != $id;
        });

        // Đảm bảo rằng các chỉ số mảng được cập nhật sau khi xóa
        $_SESSION['products'] = array_values($_SESSION['products']);
    }
}

    
}
