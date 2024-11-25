<?php
session_start();

// Đường dẫn tới file JSON
$dataFile = 'data.json';
$items = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

// Xử lý thêm, sửa, xóa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add') {
            // Thêm hoa mới
            $newItem = [
                'id' => time(),
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'image' => uploadImage($_FILES['image'])
            ];
            $items[] = $newItem;
        } elseif ($_POST['action'] === 'edit') {
            // Sửa thông tin hoa
            foreach ($items as &$item) {
                if ($item['id'] == $_POST['id']) {
                    $item['name'] = $_POST['name'];
                    $item['description'] = $_POST['description'];
                    if (!empty($_FILES['image']['name'])) {
                        $item['image'] = uploadImage($_FILES['image']);
                    }
                    break;
                }
            }
        } elseif ($_POST['action'] === 'delete') {
            // Xóa hoa
            $items = array_filter($items, function ($item) {
                return $item['id'] != $_POST['id'];
            });
        }
        // Lưu dữ liệu vào file JSON
        file_put_contents($dataFile, json_encode($items));
        header('Location: index_admin.php');
        exit();
    }
}

// Hàm upload ảnh
function uploadImage($file) {
    $targetDir = 'uploads/';
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    $fileName = time() . '-' . basename($file['name']);
    $targetFile = $targetDir . $fileName;
    move_uploaded_file($file['tmp_name'], $targetFile);
    return $targetFile;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý danh sách hoa - Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        a {
            text-decoration: none;
            color: #007BFF;
            margin-left: 10px;
        }
        button {
            padding: 8px 12px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        td img {
            display: block;
            width: 70px;
            height: 70px;
            object-fit: cover;
            margin: 0 auto;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 50%;
            margin: 20px auto;
        }
        .form-container h2 {
            text-align: center;
            color: #333;
        }
        .form-container input, .form-container textarea, .form-container button {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-container textarea {
            resize: none;
            height: 80px;
        }
        .form-container button {
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #0056b3;
        }
        .hidden {
            display: none;
        }
        .toggle-btn {
            display: block;
            text-align: center;
            margin: 20px;
        }
    </style>
    <script>
        function toggleForm(formId) {
            var form = document.getElementById(formId);
            if (form.style.display === "none" || form.style.display === "") {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        }
    </script>
</head>
<body>
    <h1>Quản lý danh sách hoa - Admin</h1>
    <a href="index.php">Chuyển sang chế độ khách</a>

    <div class="toggle-btn">
        <button onclick="toggleForm('addForm')">Thêm hoa</button>
    </div>

    <!-- Form thêm hoa -->
    <div id="addForm" class="form-container hidden">
        <h2>Thêm hoa mới</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">
            <label for="name">Tên loài hoa:</label>
            <input type="text" id="name" name="name" placeholder="Nhập tên loài hoa" required>
            
            <label for="description">Mô tả:</label>
            <textarea id="description" name="description" placeholder="Nhập mô tả về loài hoa" required></textarea>
            
            <label for="image">Hình ảnh:</label>
            <input type="file" id="image" name="image" required>
            
            <button type="submit">Thêm</button>
        </form>
    </div>

    <!-- Hiển thị danh sách hoa -->
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên hoa</th>
                <th>Mô tả</th>
                <th>Hình ảnh</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php $index = 1; foreach ($items as $item): ?>
                <tr>
                    <td><?= $index++ ?></td>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= htmlspecialchars($item['description']) ?></td>
                    <td><img src="<?= htmlspecialchars($item['image']) ?>" alt="Ảnh"></td>
                    <td>
                        <!-- Nút sửa -->
                        <button onclick="toggleForm('editForm<?= $item['id'] ?>')">Sửa</button>
                        <!-- Form sửa -->
                        <div id="editForm<?= $item['id'] ?>" class="form-container hidden">
                            <h2>Sửa thông tin hoa</h2>
                            <form method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="edit">
                                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                
                                <label for="nameEdit<?= $item['id'] ?>">Tên loài hoa:</label>
                                <input type="text" id="nameEdit<?= $item['id'] ?>" name="name" value="<?= htmlspecialchars($item['name']) ?>" required>
                                
                                <label for="descriptionEdit<?= $item['id'] ?>">Mô tả:</label>
                                <textarea id="descriptionEdit<?= $item['id'] ?>" name="description" required><?= htmlspecialchars($item['description']) ?></textarea>
                                
                                <label for="imageEdit<?= $item['id'] ?>">Hình ảnh (chọn lại nếu muốn thay đổi):</label>
                                <input type="file" id="imageEdit<?= $item['id'] ?>" name="image">
                                
                                <button type="submit">Lưu</button>
                            </form>
                        </div>
                        <!-- Nút xóa -->
                        <form method="POST" style="display: inline-block;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= $item['id'] ?>">
                            <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa?');">Xóa</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>s
</html>
