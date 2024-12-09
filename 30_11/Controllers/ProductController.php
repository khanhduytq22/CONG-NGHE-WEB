<?php

require_once 'models/ProductModel.php';

class ProductController {
    // Hiển thị danh sách sản phẩm
    public static function index() {
        ProductModel::initializeProducts();
        $products = ProductModel::getAllProducts();
        require_once 'views/product_list.php';
    }

    // Thêm sản phẩm mới
    public static function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $price = $_POST['price'];
            ProductModel::addProduct($name, $price);
            header('Location: index.php'); // Quay lại danh sách sản phẩm
            exit;
        } else {
            require_once 'views/product_form.php'; // Hiển thị form thêm sản phẩm
        }
    }

    // Sửa sản phẩm
    // Sửa sản phẩm
    public static function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $price = $_POST['price'];
    
            // Gọi phương thức sửa sản phẩm từ model
            ProductModel::updateProduct($id, $name, $price);
    
            // Chuyển hướng lại trang sau khi sửa
            header('Location: index.php');
            exit();
        }
    }
    

    // Xóa sản phẩm
    // Controller
public static function delete($id) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id']; // Nhận ID từ form

        // Gọi model để xóa sản phẩm theo ID
        ProductModel::deleteProduct($id);

        // Sau khi xóa, chuyển hướng về trang danh sách sản phẩm
        header('Location: index.php'); 
        exit();
    }
}

}
?>
