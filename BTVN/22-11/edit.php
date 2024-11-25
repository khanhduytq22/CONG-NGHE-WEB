<?php
$host = 'localhost';
$db_name = 'managerment';
$username = 'root';
$password = '12345678';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];

        $stmt = $conn->prepare("SELECT * FROM prod WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            echo "Sản phẩm không tồn tại.";
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $description = $_POST['description'];

            $image = $product['image'];
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $imageTmp = $_FILES['image']['tmp_name'];
                $imageName = basename($_FILES['image']['name']);
                $imagePath = "uploads/" . $imageName;
                if (move_uploaded_file($imageTmp, $imagePath)) {
                    $image = $imagePath;
                }
            }

            $updateStmt = $conn->prepare("UPDATE prod SET name = :name, price = :price, description = :description, image = :image WHERE id = :id");
            $updateStmt->bindParam(':name', $name);
            $updateStmt->bindParam(':price', $price);
            $updateStmt->bindParam(':description', $description);
            $updateStmt->bindParam(':image', $image);
            $updateStmt->bindParam(':id', $id);
            $updateStmt->execute();

            header("Location: index.php");
            exit();
        }

    } else {
        echo "Không có id sản phẩm.";
        exit;
    }

} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa sản phẩm</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
        .container { padding: 20px; max-width: 800px; margin: 0 auto; background-color: white; border-radius: 8px; }
        h1 { text-align: center; }
        form { display: flex; flex-direction: column; }
        input, textarea { padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; }
        button { padding: 10px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        .back-button { display: inline-block; background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>

<div class="container">
    <h1>Sửa sản phẩm</h1>
    <form method="POST" action="" enctype="multipart/form-data">
        <label for="name">Tên sản phẩm:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>

        <label for="price">Giá thành (VND):</label>
        <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>

        <label for="description">Mô tả sản phẩm:</label>
        <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($product['description']); ?></textarea>

        <label for="image">Chọn hình ảnh mới:</label>
        <input type="file" id="image" name="image" accept="image/*">

        <?php if ($product['image']): ?>
            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Hình ảnh sản phẩm" width="100">
        <?php endif; ?>

        <button type="submit">Cập nhật sản phẩm</button>
    </form>

    <a href="index.php" class="back-button">Trở lại trang danh sách</a>
</div>

</body>
</html>
