<?php
$host = 'localhost';
$db_name = 'managerment'; // Đảm bảo đúng tên database
$username = 'root';
$password = '12345678'; // Đặt mật khẩu của bạn vào đây

try {
    // Tạo kết nối
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Kiểm tra nếu có id trong URL
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];

        // Truy vấn xóa sản phẩm theo id
        $stmt = $conn->prepare("DELETE FROM prod WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Sau khi xóa thành công, chuyển hướng về trang danh sách sản phẩm
        header("Location: index.php");
        exit(); // Dừng thực thi sau khi chuyển hướng
    } else {
        echo "Không có id sản phẩm.";
        exit;
    }

} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
