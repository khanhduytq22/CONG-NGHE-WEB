<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // kiểm tra dữ liệu từ form
    // Kiểm tra tệp CSV được tải lên
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) { // kiểm tra xem có lỗi không
        $csvTmpPath = $_FILES['csv_file']['tmp_name'];
        $fileName = $_FILES['csv_file']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Kiểm tra định dạng tệp
        if ($fileExtension !== 'csv') {
            die("Chỉ chấp nhận các tệp có định dạng .csv");
        }

        // Đọc tệp CSV
        $file = fopen($csvTmpPath, 'r');
        $data = [];
        while (($row = fgetcsv($file)) !== false) {
            $data[] = $row; // Lưu từng dòng dữ liệu
        }
        fclose($file);

        // Lưu vào session để sử dụng sau này
        $_SESSION['csv_data'] = $data;

        echo "<h1>Dữ liệu từ tệp CSV:</h1>";
        echo "<table border='1' cellpadding='5'>";
        foreach ($data as $row) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";

    } else {
        echo "Tải tệp thất bại!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload CSV</title>
</head>
<body>
    <h1>Upload YOUR CSV File</h1>
    <form method="POST" enctype="multipart/form-data" action="index.php">
        <input type="file" name="csv_file" accept=".csv" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>