<?php
$host = 'localhost';
$db_name = 'managerment';
$username = 'root';
$password = '12345678';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];

        $image = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $imageTmp = $_FILES['image']['tmp_name'];
            $imageName = basename($_FILES['image']['name']);
            $imagePath = "uploads/" . $imageName;
            if (move_uploaded_file($imageTmp, $imagePath)) {
                $image = $imagePath;
            }
        }

        $sql = "INSERT INTO prod (name, price, description, image) VALUES (:name, :price, :description, :image)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);
        $stmt->execute();

        header("Location: index.php");
        exit();
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
    <title>Thêm sản phẩm mới</title>
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
    <h1>Thêm sản phẩm mới</h1>
    <form method="POST" action="" enctype="multipart/form-data">
        <label for="name">Tên sản phẩm:</label>
        <input type="text" id="name" name="name" required>

        <label for="price">Giá thành (VND):</label>
        <input type="number" id="price" name="price" required>

        <label for="description">Mô tả sản phẩm:</label>
        <textarea id="description" name="description" rows="4" required></textarea>

        <label for="image">Chọn hình ảnh:</label>
        <input type="file" id="image" name="image" accept="image/*" required>

        <button type="submit">Thêm sản phẩm</button>
    </form>

    <a href="index.php" class="back-button">Trở lại trang danh sách</a>
</div>

</body>
</html>
