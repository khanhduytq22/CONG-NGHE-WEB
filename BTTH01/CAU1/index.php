<?php
// Đường dẫn tới file JSON
$dataFile = 'data.json';
$items = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý danh sách hoa - Khách</title>
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
        a {
            text-decoration: none;
            color: #007BFF;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <h1>Danh sách hoa</h1>
    <a href="index_admin.php">Chuyển sang chế độ quản trị viên</a>

    <!-- Hiển thị danh sách hoa -->
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên hoa</th>
                <th>Mô tả</th>
                <th>Hình ảnh</th>
            </tr>
        </thead>
        <tbody>
            <?php $index = 1; foreach ($items as $item): ?>
                <tr>
                    <td><?= $index++ ?></td>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= htmlspecialchars($item['description']) ?></td>
                    <td><img src="<?= htmlspecialchars($item['image']) ?>" alt="Ảnh"></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
