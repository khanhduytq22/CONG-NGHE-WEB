<?php
$host = 'localhost';
$db_name = 'managerment';
$username = 'root';
$password = '12345678';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query("SELECT * FROM prod");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
?>
<?php include('header.php'); ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
        .container { padding: 20px; max-width: 1000px; margin: 0 auto; background-color: white; border-radius: 8px; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; text-align: center; border: 1px solid #ddd; }
        .btn { padding: 5px 10px; color: white; text-decoration: none; border-radius: 5px; }
        .btn-edit { background-color: #28a745; } /* Xanh */
        .btn-delete { background-color: #dc3545; } /* Đỏ */
        .btn-action { padding: 8px; border-radius: 50%; color: white; }
        .btn-add { background-color: #007bff; margin-bottom: 20px; display: inline-block; padding: 10px 20px; text-decoration: none; color: white; border-radius: 5px; }
        .btn-add:hover { background-color: #0056b3; }
        .btn-action:hover { opacity: 0.8; }
        img { width: 50px; }
    </style>
</head>
<body>

<div class="container">
    <h1>Danh sách sản phẩm</h1>

    <!-- Nút Thêm sản phẩm mới -->
    <a href="add.php" class="btn-add">Thêm sản phẩm mới</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Giá thành</th>
                <th>Mô tả</th>
                <th>Hình ảnh</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['id']); ?></td>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td><?php echo htmlspecialchars($product['price']); ?> VND</td>
                    <td><?php echo htmlspecialchars($product['description']); ?></td>
                    <td>
                        <?php if ($product['image']): ?>
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Hình ảnh sản phẩm">
                        <?php else: ?>
                            <span>Không có hình ảnh</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="edit.php?id=<?php echo $product['id']; ?>" class="btn-action btn-edit" title="Sửa"><i class="fas fa-edit"></i></a>
                        <a href="delete.php?id=<?php echo $product['id']; ?>" class="btn-action btn-delete" title="Xóa"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
